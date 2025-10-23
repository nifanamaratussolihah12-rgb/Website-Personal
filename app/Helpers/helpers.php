<?php

if (!function_exists('fieldLabel')) {
    function fieldLabel($label, $value) {
        if (!empty($value)) {
            return $label . ' <span class="badge" style="background-color:#90EE90; color:#000;">Sudah diisi</span>';
        } else {
            return $label . ' <span class="badge" style="background-color:#d3d3d3; color:#000;">Belum diisi</span>';
        }
    }
}
