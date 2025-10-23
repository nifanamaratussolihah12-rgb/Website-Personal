<?php

if (! function_exists('fieldLabelMulti')) {
    function fieldLabelMulti($label, ...$values) {
        $filled = collect($values)->contains(fn($val) => !empty($val));

        if ($filled) {
            return $label . ' <span class="badge" style="background-color:#90EE90; color:#000;">Sudah diisi</span>';
        } else {
            return $label . ' <span class="badge" style="background-color:#d3d3d3; color:#000;">Belum diisi</span>';
        }
    }
}
