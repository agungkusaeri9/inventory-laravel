<?php

function formatRupiah($angka)
{
    $rupiah = $angka > 0 ? number_format($angka, 0, ',', '.') : "0";
    return "Rp $rupiah";
}
