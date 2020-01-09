define([
  'jquery',
  'googleMapPlaceLibrary'
], function ($) {
  "use strict";
  $.widget('checkout.googleAddressAutofill', {
    options: {
      loopShipping: 0,
      loopBilling: 0,
      componentForm: {
        street_number: 'street_1',
        route: 'route',
        locality: 'city',
        administrative_area_level_2: 'city',
        administrative_area_level_1: 'region',
        country: 'country',
        postal_code: 'zip'
      },
      shippingAutocomplete: null,
      billingAutocomplete: null,
      billingStreetFound: false,
      billingFunction: null,
      shippingAutoPopulateFlag:false,
      billingAutoPopulateFlag:false,
      bindChangeEventBilling:false
    },

    /**
     *
     * @private
     */
    _create: function () {
      var self = this;
      var bindChangeEvent = false;
      
      // bind gmap autocomplete
      this.options.shippingFunctions = setInterval(function() { //shippingAddress.custom_attributes.delivery_address_attribute
        var delivery_address_attribute = $('#shipping-new-address-form').find('div[name="shippingAddress.custom_attributes.delivery_address_attribute"] input')[0];

        var countryRestrictions = [];
        var countryField = $('#shipping-new-address-form').find('select[name="country_id"]')[0];
        if(countryField){
          countryRestrictions.push(countryField.value);
          if(!bindChangeEvent){
            bindChangeEvent = true;
              $(countryField).on("change", function(){
                  self.options.shippingAutocomplete.setComponentRestrictions({'country': [$(this).val()]});
              })
          }
          
          //countryRestrictions = selected_country.val().split(',');
        } else {
          countryRestrictions = self._getCountriesCodeArray();
        }
        console.log(countryRestrictions);
        if (delivery_address_attribute && bindChangeEvent) {
          self.options.shippingAutoPopulateFlag = true;
          self.options.shippingAutocomplete = new google.maps.places.Autocomplete(
            delivery_address_attribute,
            {types: ['geocode']}
          );
          self.options.shippingAutocomplete.inputId = delivery_address_attribute.id;
          self.options.shippingAutocomplete.setComponentRestrictions({'country': countryRestrictions});
          google.maps.event.addListener(self.options.shippingAutocomplete, 'place_changed', function () {
            var place = self.options.shippingAutocomplete.getPlace();
            console.log(place);
            delivery_address_attribute.value = place.formatted_address;
            $(delivery_address_attribute).trigger("change");
            for (var i = place.address_components.length-1; i >= 0; i--) {
              var addressType = place.address_components[i].types[0];
              var long_name = place.address_components[i].long_name;
              var short_name = place.address_components[i].short_name;
              
              if (self.options.componentForm[addressType] && long_name) {
                if (self.options.componentForm[addressType] == 'country') {
                  $('#shipping-new-address-form select[name="country_id"]').val(short_name).trigger('change');
                } else if (self.options.componentForm[addressType] == 'region') {
                  $('#shipping-new-address-form input[name="region"]').val(long_name).trigger('keyup');
                  if ($('#shipping-new-address-form select[name="region_id"] option:contains('+long_name+')')) {
                    $('#shipping-new-address-form select[name="region_id"] option:contains('+long_name+')').prop('selected', true).trigger('change');
                  }
                } else if (self.options.componentForm[addressType] == 'route') {
                  $('#shipping-new-address-form input[name="street[0]"]').val(long_name).trigger('keyup').trigger('keyup');
                } else if (self.options.componentForm[addressType] == 'street_1') {
                  $('#shipping-new-address-form input[name="street[0]"]').val(long_name + ' '+ $('#shipping-new-address-form input[name="street[0]"]').val()).trigger('keyup');
                } else if (self.options.componentForm[addressType] == 'zip') {
                  $('#shipping-new-address-form input[name="postcode"]').val(long_name).trigger('keyup');
                } else {
                  $('#shipping-new-address-form input[name="'+self.options.componentForm[addressType]+'"]').val(long_name).trigger('keyup');
                }
              }
            }
          });
          //clearInterval(self.options.shippingFunctions);
        }
        if(self.options.shippingAutoPopulateFlag){
          clearInterval(self.options.shippingFunctions);
        }
      }, 2000);

      self._fillInCheckoutBillingAddress();


    },

    /**
     * Fill in billing address
     *
     * @private
     */
    _fillInCheckoutBillingAddress() {
      var self = this;
      if (!this.options.billingStreetFound) {
        this.options.billingFunctions = setInterval(function() { //billingAddress.custom_attributes.delivery_address_attribute
          var delivery_address_attribute = $('div.checkout-billing-address').find('div[name="billingAddress.custom_attributes.delivery_address_attribute"] input')[0];

          var countryRestrictions = [];
        var countryField = $('div.checkout-billing-address').find('select[name="country_id"]')[0];
        if(countryField){
          countryRestrictions.push(countryField.value);
          if(!self.options.bindChangeEventBilling){
            self.options.bindChangeEventBilling = true;
              $(countryField).on("change", function(){
                  self.options.billingAutocomplete.setComponentRestrictions({'country': [$(this).val()]});
              })
          }
          
          //countryRestrictions = selected_country.val().split(',');
        } 
          if (delivery_address_attribute && self.options.bindChangeEventBilling) {

            self.options.billingAutoPopulateFlag = true;
            self.options.billingAutocomplete = new google.maps.places.Autocomplete(
              delivery_address_attribute,
              {types: ['geocode']}
            );
            self.options.billingAutocomplete.inputId = delivery_address_attribute.id;
            self.options.billingAutocomplete.setComponentRestrictions({'country': countryRestrictions});
            google.maps.event.addListener(self.options.billingAutocomplete, 'place_changed', function () {
              var place = self.options.billingAutocomplete.getPlace();
              console.log(place);
              delivery_address_attribute.value = place.formatted_address;
              $(delivery_address_attribute).trigger("change");
              for (var i = place.address_components.length-1; i >= 0; i--) {
                var addressType = place.address_components[i].types[0];
                var long_name = place.address_components[i].long_name;
                var short_name = place.address_components[i].short_name;
                if (self.options.componentForm[addressType] && long_name) {
                  if (self.options.componentForm[addressType] == 'country') {
                    $('.checkout-billing-address select[name="country_id"]').val(short_name).trigger('change');
                  } else if (self.options.componentForm[addressType] == 'region') {
                    $('.checkout-billing-address input[name="region"]').val(long_name).trigger('keyup');
                    if ($('.checkout-billing-address select[name="region_id"] option:contains('+long_name+')')) {
                      $('.checkout-billing-address select[name="region_id"] option:contains('+long_name+')').prop('selected', true).trigger('change');
                    }
                  } else if (self.options.componentForm[addressType] == 'route') {
                    $('.checkout-billing-address input[name="street[0]"]').val(long_name).trigger('keyup').trigger('keyup');
                  } else if (self.options.componentForm[addressType] == 'street_1') {
                    $('.checkout-billing-address input[name="street[0]"]').val(long_name + ' '+ $('.checkout-billing-address input[name="street[0]"]').val()).trigger('keyup');
                  } else if (self.options.componentForm[addressType] == 'zip') {
                    $('.checkout-billing-address input[name="postcode"]').val(long_name).trigger('keyup');
                  } else {
                    $('.checkout-billing-address input[name="'+self.options.componentForm[addressType]+'"]').val(long_name).trigger('keyup');
                  }
                }
              }
            });
            //clearInterval(self.options.billingFunctions);
            self.options.billingStreetFound = true;
          }
          if(self.options.billingAutoPopulateFlag){
            clearInterval(self.options.billingFunctions);
          }


        }, 2000);
      }
    },

    /**
     * Convert countries code to array
     *
     * @private
     */
    _getCountriesCodeArray() {
      var countries = this.options.countries;
      return countries.split(',');
    }
  });
  return $.checkout.googleAddressAutofill;
});