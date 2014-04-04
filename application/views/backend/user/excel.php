<?php
    $headers = "id\temail\tnombre\tservicio\troles\tministerial\tinterministeria\n";
    $body = "";
    foreach ($users as $user) {
        $a_rol = array();

        foreach ($user->getRols() as $key => $rol){
            $a_rol[] = $rol->getNombre();
        }
        $roles = (count($a_rol)?implode(',', $a_rol):'');

        $servicio = $user->getServicio()?$user->getServicio()->getNombre():'';

        $line = $user->getId()."\t".
                $user->getEmail()."\t".
                $user->getFullName()."\t".
                $servicio."\t".
                $roles."\t".
                ($user->getMinisterial()?'Si':'No')."\t".
                ($user->getInterministerial()?'Si':'No')."\n";

        $body .= $line;
    }

    echo $headers.$body;
?>