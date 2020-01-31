$(function () {

    initComplexArea('seachprov', 'seachcity', 'seachdistrict', area_array, sub_array, '51', '0', '0');
    initComplexArea('seachprov2', 'seachcity2', 'seachdistrict2', area_array, sub_array, '51', '0', '0');


    $("#seachprov").change(function () {
        changeComplexProvince(this.value, sub_array, 'seachcity', 'seachdistrict');

    });

    $("#seachcity").change(function () {
        changeCity(this.value,'seachdistrict','seachdistrict');

    });

    $("#seachprov2").change(function () {
        changeComplexProvince(this.value, sub_array, 'seachcity2', 'seachdistrict2');

    });

    $("#seachcity2").change(function () {
        changeCity(this.value,'seachdistrict2','seachdistrict2');

    });


});




