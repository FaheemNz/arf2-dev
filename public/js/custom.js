$(function () {
    $("#has_laptop").click(function () {
        if ($("#has_laptop").is(":checked")) {
            $("#laptop-row").find(".arf-toggle-input").removeAttr("disabled");
            $("#btn_arf_laptop_search")
                .prop("disabled", false)
                .css("pointer-events", "all");
        } else {
            $("#laptop-row").find(".arf-toggle-input").attr("disabled", true);
            $("#btn_arf_laptop_search")
                .prop("disabled", true)
                .css("pointer-events", "none");
        }
    });

    $("#has_tablet").click(function () {
        if ($("#has_tablet").is(":checked")) {
            $("#tablet-row").find(".arf-toggle-input").removeAttr("disabled");
            $("#btn_arf_tablet_search")
                .prop("disabled", false)
                .css("pointer-events", "all");
        } else {
            $("#tablet-row").find(".arf-toggle-input").attr("disabled", true);
            $("#btn_arf_tablet_search")
                .prop("disabled", true)
                .css("pointer-events", "none");
        }
    });

    $("#has_sim").click(function () {
        if ($("#has_sim").is(":checked")) {
            $("#sim-row").find(".arf-toggle-input").removeAttr("disabled");
            $("#btn_arf_sim_search")
                .prop("disabled", false)
                .css("pointer-events", "all");
        } else {
            $("#sim-row").find(".arf-toggle-input").attr("disabled", true);
            $("#btn_arf_sim_search")
                .prop("disabled", true)
                .css("pointer-events", "none");
        }
    });

    $("#has_desktop").click(function () {
        if ($("#has_desktop").is(":checked")) {
            $("#desktop-row").find(".arf-toggle-input").removeAttr("disabled");
            $("#btn_arf_desktop_search")
                .prop("disabled", false)
                .css("pointer-events", "all");
        } else {
            $("#desktop-row").find(".arf-toggle-input").attr("disabled", true);
            $("#btn_arf_desktop_search")
                .prop("disabled", true)
                .css("pointer-events", "none");
        }
    });

    $("#has_monitor").click(function () {
        if ($("#has_monitor").is(":checked")) {
            $("#monitor-row").find(".arf-toggle-input").removeAttr("disabled");
            $("#btn_arf_monitor_search")
                .prop("disabled", false)
                .css("pointer-events", "all");
        } else {
            $("#monitor-row").find(".arf-toggle-input").attr("disabled", true);
            $("#btn_arf_monitor_search")
                .prop("disabled", true)
                .css("pointer-events", "none");
        }
    });

    $("#has_mobile").click(function () {
        if ($("#has_mobile").is(":checked")) {
            $("#mobile-row").find(".arf-toggle-input").removeAttr("disabled");
            $("#btn_arf_mobile_search")
                .prop("disabled", false)
                .css("pointer-events", "all");
        } else {
            $("#mobile-row").find(".arf-toggle-input").attr("disabled", true);
            $("#btn_arf_mobile_search")
                .prop("disabled", true)
                .css("pointer-events", "none");
        }
    });

    $("#arf-name").on("change", function () {
        if ($(this).val()) {
            $("#signature-name").text($(this).val());
            $("#arf-email").val(
                $(this).val()
                    .split(" ")
                    .join(".")
                    .toLowerCase() +
                    "@azizidevelopments.com"
            );
        }
    });
});

let modal = new bootstrap.Modal(document.getElementById("asset-search-modal"));

$(document).on("click", ".searchModalTrigger", function () {
    let tableName = $(this).attr("data-table"),
        assetCode = $(this).attr("data-field-asset-code"),
        assetBrand = $(this).attr("data-field-brand");

    if (!tableName || !assetCode || !assetBrand) {
        console.log(tableName, assetCode, assetBrand);
        
        alert("Script Parsing Issue.");
        
        return;
    }

    searchModalTrigger(tableName, assetCode, assetBrand);
});

function searchModalTrigger(tableName, assetCode, assetBrand) {
    $("#table").val(tableName);
    $("#c_asset_code").val(assetCode);
    $("#c_brand").val(assetBrand);
    $("#is-available").addClass("d-none");

    let assetTypeAjax = $("#asset_code_ajax");

    assetTypeAjax.empty();

    $.ajax({
        method: "GET",
        url: "/search-asset-availability",
        data: {
            table: tableName
        },
        success: function (response) {
           if(response.success == true){
                let dataFromAjax = response.data.data;
                
                assetTypeAjax.select2({
                    placeholder: "Select Asset",
                    dropdownParent: $('#asset-search-modal'),
                    width: "470px",
                    data: response.data.data
                });
           } else {
                alert("No Asset is Available");
           }
        },
        error: function (error) {
            console.log(error);

            alert("Some Error Occured");
        },
    });
    
    modal.show();
}

function fillAssetDetails(){
    let fromAjaxAsset = $("#asset_code_ajax").select2("data"),
        table = $('#table').val();

    if(!fromAjaxAsset){
        alert("Please select a valid asset");
        
        return;
    }
    
    let theCode = fromAjaxAsset[0].text
    
    table = table.slice(0, -1);
    
    $("#arf_" + table + "_asset_code").val( theCode );

    modal.hide();
}

function preSelectOfficeLocation(deptId) {
    let officeLocations = [
        { dept_id: 1, floor: 2 }, // Asset        => 8
        { dept_id: 2, floor: 1 }, // Audit        => 5,
        { dept_id: 3, floor: 2 }, // CRM          => 8
        { dept_id: 4, floor: 5 }, // VCM          => 14
        { dept_id: 5, floor: 5 }, // Sales        => 14
        { dept_id: 6, floor: 5 }, // S.Admin      => 14
        { dept_id: 7, floor: 6 }, // Techtiq      => 15
        { dept_id: 8, floor: 6 }, // Legacious    => 15
        { dept_id: 9, floor: 6 }, // Eng          => 15,
        { dept_id: 10, floor: 6 }, // PMO          => 15,
        { dept_id: 11, floor: 6 }, // Gardinia     => 15,
        { dept_id: 12, floor: 5 }, // Procurement  => 14,
        { dept_id: 13, floor: 1 }, // Finance      => 5,
        { dept_id: 14, floor: 2 }, // Handover     => 8,
        { dept_id: 15, floor: 4 }, // Agency       => 13,
        { dept_id: 16, floor: 4 }, // Telesales    => 13,
        { dept_id: 17, floor: 4 }, // Marketing    => 13,
        { dept_id: 18, floor: 5 }, // Agency       => 13,
        { dept_id: 19, floor: 2 }, // Admin        => 8,
        { dept_id: 20, floor: 2 }, // Operation    => 8,
    ];

    if (!deptId) {
        return;
    }

    let theOffice = officeLocations.find((o) => o.dept_id == deptId).floor;

    $("#arf_office_location option[value=" + theOffice + "]").prop(
        "selected",
        true
    );
}

function loadBrands(elem){
    let type = elem.value,
        assetBrand = $("#asset_brand");

    if(!type){
        return;
    }

    if(type == 'Tablet'){
        $('#asset_codes').prop('disabled', false);
        $('#asset_from').prop('disabled', true);
        $('#number_of_assets').prop('disabled', true);
    } else {
        $('#asset_codes').prop('disabled', true);
        $('#asset_from').prop('disabled', false);
        $('#number_of_assets').prop('disabled', false);
    }

    assetBrand.empty();

    $.ajax({
        url: "/get-brands",
        method: "GET",
        data: {
            type: type
        },
        success: function(response){
            if(response.success == true){
                assetBrand.append(`<option value="">Select</option>`);
                response.data.forEach(brand => {
                    assetBrand.append(`<option value="${brand}">${brand}</option>`);
                });
            } else {
                alert("No Brand found");
            }
        },
        error: function(error){
            console.log(error);

            alert("Some Error Occured. Please try again later")
        }
    });
}
