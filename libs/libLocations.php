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
function getLocations()
{
    global $conn;
    $sql = "SELECT id , user_id ,title , lat , lng , type , status , created_at FROM locations";
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
    return $locations;
}
