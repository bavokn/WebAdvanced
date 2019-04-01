<?php
namespace view;

class jsonuserview implements View
{
    public function show(array $data)
    {
        header('Content-Type: application/json');
        http_response_code($data['statuscode']);
        $person = $data['user'];
        print(json_encode($person));
    }
}
