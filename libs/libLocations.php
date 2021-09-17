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

    $typeCondition = null;
    if (isset($params['type']) and is_numeric($params['type'])) {
        $typeCondition =  "WHERE type LIKE {$params['type']}";
    }

    $sortCondtion = null;
    // 0 equal to desc and 1 equal to asc
    if (isset($params['sort']) and in_array($params['sort'], [0, 1])) {
        $sortBy = $params['sort'] ? 'ASC' : 'DESC';
        $typeCondition =  "ORDER BY created_at {$sortBy}";
    }

    $sql = "SELECT id , user_id ,title , lat , lng , type , status , created_at FROM locations {$activeCondition} {$typeCondition} {$sortCondtion}";
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
        $condition =  "AND lat BETWEEN $lat - $areaLatLng AND $lat + $areaLatLng AND lng BETWEEN $lng - $areaLatLng AND $lng + $areaLatLng  AND type LIKE $type";
        // $condition =  "AND lat > $lat-$areaLatLng AND lat < $lat+$areaLatLng AND type LIKE $type";
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


function deleteLocation(int $id): bool
{
    global $conn;
    $sql = "DELETE FROM locations WHERE id LIKE ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    return $stmt->execute() ? true : false;
}
