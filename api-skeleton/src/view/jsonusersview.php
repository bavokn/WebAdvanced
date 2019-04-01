<?php
namespace view;

class jsonusersview implements View
{
    public function show(array $data)
    {
        header('Content-Type: application/json');
        http_response_code($data['statuscode']);
        $persons = $data['users'];
        print(json_encode($persons));
    }
}
