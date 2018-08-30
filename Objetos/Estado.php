<?php
    class Estado extends SplEnum{
        const __default = self::EN_ESPERA;

        const APROBADA = 1;
        const NO_APROBADA = 2;
        const EN_ESPERA = 3;
    }
?>