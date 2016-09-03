<?php

namespace Gregoriohc\Preview;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function show($view, Request $request)
    {
        if (!PreviewServiceProvider::isEnabled()) {
            abort(404);
        }

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
                        default:
                            if (2 == count($parts) && is_numeric($parts[1])) {
                                list($class, $id) = $parts;
                                if (class_exists($class)) {
                                    try {
                                        $object = new $class();
                                        if ($object instanceof Model && is_numeric($id)) {
                                            $value = call_user_func_array([$class, 'findOrFail'], [$id]);
                                        }
                                    } catch (Exception $e) { /** Ignore errors */ }
                                }
                            } else {
                                list($class, $method) = array_slice($parts, 0, 2);
                                $params = array_slice($parts, 2);
                                if (class_exists($class)) {
                                    $updated = false;
                                    try {
                                        if (is_callable([$class, $method])) {
                                            $value = call_user_func_array([$class, $method], $params);
                                            $updated = true;
                                        }
                                    } catch (Exception $e) { /** Ignore errors */ }
                                    if (!$updated) {
                                        try {
                                            if (is_callable([$class, $method])) {
                                                $object = new $class();
                                                if (is_callable([$object, $method])) {
                                                    $value = call_user_func_array([$object, $method], $params);
                                                }
                                            }
                                        } catch (Exception $e) { /** Ignore errors */ }
                                    }
                                }
                            }
                            break;
                    }
                    break;
            }
        });

        return view($view, $data);
    }
}
