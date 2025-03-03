$(document).ready(function () {

    $("#filters input[type='checkbox']").on("change", function () {
        filterItems();      
        updateCheckboxes();  
    });
  
      function filterItems() {
        
        let selectedFilters = {
            brand: [],  
            gender: [],
            color: [],  
            price: [],
            
        };
  
  
        $("#filters input[name='brand']:checked").each(function () {
            selectedFilters.brand.push($(this).val());
        });
  
        $("#filters input[name='gender']:checked").each(function () {
            selectedFilters.gender.push($(this).val());
        });
  
        $("#filters input[name='color']:checked").each(function () {
            selectedFilters.color.push($(this).val());
        });
  
        $("#filters input[name='price']:checked").each(function () {
            selectedFilters.price.push($(this).val());
        });
  
        $("#Jeans article").each(function () {
            let $item = $(this);
  
            let match = true;
            $.each(selectedFilters, function (filterType, filterValues) {
                if (
                    filterValues.length > 0 &&  
                    !filterValues.includes($item.data(filterType))
                ) {
                    match = false; 
                    return false;  
                }
            });
  
            if (match) {
                $item.show();  
            } else {
                $item.hide();
            }
        });
    }
  
    function updateCheckboxes() {
        
        ["brand", "gender", "color", "price"].forEach(function (filterType) {
            
            let activeFilters = {
                brand: $("#filters input[name='brand']:checked").map(function () {
                    return $(this).val();
                }).get(),
                gender: $("#filters input[name='gender']:checked").map(function () {
                    return $(this).val();
                }).get(),
                color: $("#filters input[name='color']:checked").map(function () {
                    return $(this).val();
                }).get(),
                price: $("#filters input[name='price']:checked").map(function () {
                    return $(this).val();
                }).get(),
            };
  
            activeFilters[filterType] = [];
  
            $(`#filters input[name="${filterType}"]`).each(function () {
                let filterValue = $(this).val(); 
                let isAvailable = $("#Jeans article").filter(function () {
                    let $item = $(this);
  
                    let match = true;
                    $.each(activeFilters, function (type, values) {
                        if (values.length > 0 && !values.includes($item.data(type))) {
                            match = false;
                            return false;
                        }
                    });
  
                    return match && $item.data(filterType) === filterValue;
                }).length > 0;
  
                $(this).prop("disabled", !isAvailable);
            });
        });
    }
  
    filterItems();      
    updateCheckboxes();
  });