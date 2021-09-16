<?php

function getCurentUserId()
{
    return true;
}

//---------------------------------------Add Location in DataBase---------------------------------------
function addLoc($lat, $lng, $name, $type): bool
{
    global $conn;
    $curentUserId = getCurentUserId();
    $sql = "INSERT INTO locations(user_id , title , lat , lng , type) VALUES (? ,? ,? ,? ,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('isddi', $curentUserId, $name, $lat, $lng, $type);
    if ($stmt->execute()) {
        return true;
    }
    return false;
}

//---------------------------------------Add Location in DataBase---------------------------------------
function getLocations($params = null)
{
    global $conn;
    $activeCondition = null;
    if (isset($params['active']) and in_array($params['active'], [0, 1])) {
        $activeCondition =  "WHERE status LIKE {$params['active']}";
    }
    $sql = "SELECT id , user_id ,title , lat , lng , type , status , created_at FROM locations {$activeCondition}";
    $stmt = $conn->prepare($sql);
    $stmt->bind_result($id, $user_id, $title, $lat, $lng, $type, $status, $created_at);
    $stmt->execute();
    $counter = 0;
    while ($stmt->fetch()) {
        $locations[$counter] = [
            'id'        => $id,
            'userId'    => $user_id,
            'title'     => $title,
            'lat'       => $lat,
            'lng'       => $lng,
            'type'      => $type,
            'status'    => $status,
            'createdAt' => $created_at
        ];
        $counter++;
    }
    return $locations ?? null;
}



function changeStatus($status, $id)
{
    global $conn;
    $sql = "UPDATE locations SET status = ? WHERE id LIKE ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $status, $id);
    return $stmt->execute() ? true : false;
}


function getSingleLoc(int $id)
{
    global $conn;
    $sql = "SELECT id , user_id ,title , lat , lng , type , status , created_at FROM locations WHERE id LIKE ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->bind_result($id, $user_id, $title, $lat, $lng, $type, $status, $created_at);
    $stmt->execute();
    $stmt->fetch();
    $location = [
        'id'        => $id,
        'userId'    => $user_id,
        'title'     => $title,
        'lat'       => $lat,
        'lng'       => $lng,
        'type'      => $type,
        'status'    => $status,
        'createdAt' => $created_at
    ];
    return $location ?? null;
}


function searchLoc(string $param)
{
    global $conn;
    $char = "%{$param}%";
    $sql = "SELECT id , user_id , title , lat , lng , type , status , created_at 
    FROM locations WHERE title LIKE ? AND status = 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $char);
    $stmt->bind_result($id, $user_id, $title, $lat, $lng, $type, $status, $created_at);
    $stmt->execute();
    $counter = 0;
    while ($stmt->fetch()) {
        $locations[$counter] = [
            'id'        => $id,
            'userId'    => $user_id,
            'title'     => $title,
            'lat'       => $lat,
            'lng'       => $lng,
            'type'      => $type,
            'status'    => $status,
            'createdAt' => $created_at
        ];
        $counter++;
    }
    return $locations ?? null;
}


function listOfVerifideLoc(int $area = null, int $type = null, $lat = null, $lng = null)
{
    global $conn;
    $condition = null;
    if (
        !is_null($area) and !is_null($type) and !is_null($lat) and !is_null($lng) and
        is_numeric($area) and is_numeric($type)
    ) {
        $areaLatLng = toggleToLatLng($area);
        $condition =  "AND lat BETWEEN $lat - $areaLatLng AND $lat + $areaLatLng AND type LIKE $type";
    }
    $sql = "SELECT id , user_id ,title , lat , lng , type , status , created_at FROM locations WHERE status LIKE 1 $condition";
    $stmt = $conn->prepare($sql);
    $stmt->bind_result($id, $user_id, $title, $lat, $lng, $type, $status, $created_at);
    $stmt->execute();
    $counter = 0;
    while ($stmt->fetch()) {
        $locations[$counter] = [
            'id'        => $id,
            'userId'    => $user_id,
            'title'     => $title,
            'lat'       => $lat,
            'lng'       => $lng,
            'type'      => $type,
            'status'    => $status,
            'createdAt' => $created_at
        ];
        $counter++;
    }
    return $locations ?? null;
}
