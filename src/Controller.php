<?php

namespace Gregoriohc\Preview;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use Exception;

class Controller extends BaseController
{
    public function show($view, Request $request)
    {
        if (!PreviewServiceProvider::isEnabled()) abort(404);

        $data = $request->all();

        array_walk($data, function (&$value) {
            switch ($value) {
                case is_object(json_decode($value)):
                    $value = json_decode($value);
                    break;
                case str_contains($value, '::'):
                    $parts = explode('::', $value);

                    switch (count($parts)) {
                        case 0:
                            break;
                        case 1:
                            break;
                        case 2:
                            list($class, $id) = $parts;
                            if (class_exists($class)) {
                                try {
                                    $object = new $class;
                                    if ($object instanceof Model && is_numeric($id)) {
                                        $value = call_user_func_array([$class, 'findOrFail'], [$id]);
                                    }
                                } catch (Exception $e) {
                                    // Ignore errors
                                }
                            }
                            break;
                        default: {
                            list($class, $method) = array_slice($parts, 0, 2);
                            $params = array_slice($parts, 2);
                            if (class_exists($class)) {
                                try {
                                    if (is_callable([$class, $method])) {
                                        $value = call_user_func_array([$class, $method], $params);
                                    } else {
                                        $object = new $class;
                                        if (is_callable([$object, $method])) {
                                            $value = call_user_func_array([$object, $method], $params);
                                        }
                                    }
                                } catch (Exception $e) {
                                    // Ignore errors
                                }
                            }
                            break;
                        }
                    }
                    break;
            }
        });

        return view($view, $data);
    }
}
