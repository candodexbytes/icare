$(document).ready(function () {
    jQuery("#property-add-form").validate({
        rules: {
            township_name: {
                required: true,
            },
            country_name: {
                required: true,
            },
            state: {
                required: true,
            },
            city_name: {
                required: true,
            },
            zipcode: {
                required: true,
                number: true,
                minlength: 4
            },
            area_name: {
                required: true,
            },
            property_type: {
                required: true,
            },
            property_management_contact: {
                required: true,
            },
            resident_committee_contact: {
                required: true,
            },
        },
        messages: {
            township_name: {
                required: 'Please enter property name',
            },
            country_name: {
                required: 'Please select country',
            },
            state: {
                required: 'Please enter state name',
            },
            city_name: {
                required: 'Please enter city name',
            },
            zipcode: {
                required: 'Please enter area postcode',
            },
            area_name: {
                required: 'Please enter area name',
            },
            property_type: {
                required: 'Please enter property type',
            },
            property_management_contact: {
                required: 'Please enter property management contact',
            },
            resident_committee_contact: {
                required: 'Please enter resident commitee contact',
            },
            image_file: {
                required: 'Please select image file',
            },
        }
    });
    jQuery("#new-message-form").validate({
        rules: {
            subject: {
                required: true,
            },
            from: {
                required: true,
            },
            sent_to: {
                required: true,
            }
        },
        messages: {
            subject: {
                required: 'Please enter subject',
            },
            from: {
                required: 'Please enter from mobile number',
            },
            sent_to: {
                required: 'Please select sent to',
            }
        }
    });
    jQuery("#update_property_form").validate({
        rules: {
            township_name: {
                required: true,
            },
            country_name: {
                required: true,
            },
            state: {
                required: true,
            },
            city_name: {
                required: true,
            },
            zipcode: {
                required: true,
                number: true,
            },
            area_name: {
                required: true,
            },
            property_type: {
                required: true,
            },
            property_management_contact: {
                required: true,
            },
            resident_committee_contact: {
                required: true,
            }
        },
        messages: {
            township_name: {
                required: 'Please enter propetry name',
            },
            country_name: {
                required: 'Please select country',
            },
            state: {
                required: 'Please enter state name',
            },
            city_name: {
                required: 'Please enter city name',
            },
            zipcode: {
                required: 'Please enter area zipcode',
            },
            area_name: {
                required: 'Please enter area name',
            },
            property_type: {
                required: 'Please enter property type',
            },
            property_management_contact: {
                required: 'Please enter property management contact',
            },
            resident_committee_contact: {
                required: 'Please enter resident committe contact',
            }
        }
    });
    jQuery("#add-notice-form").validate({
        rules: {
            subject: {
                required: true,
            },
            end_date: {
                required: true,
            },
        },
        messages: {
            subject: {
                required: 'Please enter subject',
            },
            end_date: {
                required: 'Please select end date',
            }
        }
    });
    jQuery("#update_notice_form").validate({
        rules: {
            subject: {
                required: true,
            },

        },
        messages: {
            subject: {
                required: 'Please enter subject',
            },

        }
    });
    jQuery("#maintenancefees-add-form").validate({
        rules: {
            invoice_date:{
                required: true,
            },
            due_due:{
                required: true,
            },
            grand_total: {
                required: true,
                number: true,
                min: 1
            },
            pdf_file: {
                required: true,
                accept: "pdf"
            }
        },
        messages: {
            invoice_date:{
                 required: 'Please enter invoice date',
            },
            due_due:{
                 required: 'Please enter due date',
            },
            grand_total: {
                required: 'Please enter amount',
                number: 'Please enter number digit',
                min: 'Invoice amount must be required greater than 0'
            },
            pdf_file: {
                required: 'Please select pdf file',
                accept: "Please select only pdf file"
            },
        }
    });
    jQuery("#update_maintenancefees_form").validate({
        rules: {
            charge: {
                required: true,
                number: true
            },
            balance: {
                required: true,
                number: true
            },
            amount_due: {
                required: true,
                number: true,
                min: 0
            },
            pdf_file: {
                accept: "pdf"
            }
        },
        messages: {
            charge: {
                required: 'Please enter charge',
                number: 'Please enter number digit'
            },
            balance: {
                required: 'Please select country',
                number: 'Please enter number digit'
            },
            amount_due: {
                required: 'Please enter city name',
                number: 'Please enter number digit'
            },
            pdf_file: {
                accept: "Please select only pdf file"
            }
        }
    });

    jQuery("#emergency-form").validate({
        rules: {
            subject: {
                required: true,
            },
            title: {
                required: true,
            },
            cell_number: {
                required: true,
                number: true
            },
            type: {
                required: true,

            },
            image_file: {
                required: true,

            }
        },
        messages: {
            subject: {
                required: 'Please enter subject',
            },
            title: {
                required: 'Please enter coupon title',
            },
            cell_number: {
                required: 'Please enter mobile number',
                number: 'Please enter mobile number in digit'
            },
            type: {
                required: 'Please select coupon type',

            },
            image_file: {
                required: 'Please select icon image',

            }
        }
    });
    jQuery("#update_RcMcUser_form").validate({
        rules: {
            name: {
                required: true,
            },
            password: {
                minlength: 8,
                maxlength: 20
            },
            confirm_password: {
                equalTo: "#password"
            },
            mobile_number: {
                required: true,
                number: true,
            }
         },
        messages: {
            name: {
                required: 'Please enter name',
            },
            password: {
                required: 'Please enter password',
            },
            confirm_password: {
                required: 'Please enter current password',
                equalTo: "Password and confirm password do not match"
            },
            mobile_number: {
                required: 'Please select cell number',
                number: 'Please enter number digit'               
            }

        }
    });
    jQuery("#update_contact_form").validate({
        rules: {
            name: {
                required: true,
            },
            cell_number: {
                required: true,
                number: true
            },

        },
        messages: {
            name: {
                required: 'Please enter name',
            },
            cell_number: {
                required: 'Please select mobile number',
                number: 'Please enter mobile number in digit'
            },

        }
    });
    jQuery("#subadmin-form").validate({
        rules: {
            name: {
                required: true,
            },
            email: {
                required: true,
                email: true
            },
            cell_number: {
                required: true,
                number: true
            },
            password: {
                required: true,
                minlength: 8,
                maxlength: 20
            },
            confirm_password: {
                required: true,
                equalTo: "#password"
            }
        },
        messages: {
            name: {
                required: 'Please enter name',
            },
            email: {
                required: 'Please enter email',
                email: 'Please enter correct email id'
            },
            cell_number: {
                required: 'Please enter mobile number',
                number: 'Please enter only number digit'
            },
            password: {
                required: 'Please enter password',
            },
            confirm_password: {
                required: 'Please enter current password',
                equalTo: "Password and confirm password do not match"
            }
        }
    });

    jQuery("#adduser-form").validate({
        rules: {
            name: {
                required: true,
            },
            nric: {
                required: true,
                minlength: 1,
                maxlength: 20
            },
            email: {
                required: true,
                email: true
            },
            cell_number: {
                required: true,
                number: true
            },
            house_number:{
              required: true 
            },
            block_number:{
             required: true   
            },
            address:{
             required: true  
            },
            password: {
                required: true,
                minlength: 8,
                maxlength: 20,
            },
            confirm_password: {
                required: true,
                equalTo: "#password"
            }
        },
        messages: {
            name: {
                required: 'Please enter name',
            },
            nric: {
                required: 'Please enter nric number',
            },
            email: {
                required: 'Please enter email',
                email: 'Please enter correct email id'
            },
            cell_number: {
                required: 'Please enter mobile number',
                number: 'Please enter only number digit'
            },
            house_number: {
                required: 'Please enter house number',
            },
            block_number: {
                required: 'Please enter block number',
            },
            address: {
                required: 'Please enter address',
            },
            password: {
                required: 'Please enter password',
            },
            confirm_password: {
                required: 'Please enter current password',
                equalTo: "Password and confirm password do not match"
            }
        }
    });
    jQuery("#update_residentuser_form").validate({
        rules: {
            name: {
                required: true,
            },
            nric: {
                required: true,
                minlength: 1,
                maxlength: 20
            },
            email: {
                required: true,
                email: true
            },
            cell_number: {
                required: true,
                number: true
            },
          /*   house_number:{
              required: true 
            },
            block_number:{
             required: true   
            },
            address:{
             required: true  
            }, */
            password: {
                minlength: 8,
                maxlength: 20,
            },
            confirm_password: {
                equalTo: "#password"
            }
        },
        messages: {
            name: {
                required: 'Please enter name',
            },
            nric: {
                required: 'Please enter nric number',
            },
            email: {
                required: 'Please enter email',
                email: 'Please enter correct email id'
            },
            cell_number: {
                required: 'Please enter mobile number',
                number: 'Please enter only number digit'
            },
            /*  house_number: {
                required: 'Please enter house number',
            },
            block_number: {
                required: 'Please enter block number',
            },
            address: {
                required: 'Please enter address',
            }, */
            password: {
//                required: 'Please enter password',
            },
            confirm_password: {
//                required: 'Please enter current password',
                equalTo: "Password and confirm password do not match"
            }
        }
    });
    jQuery("#update_tenantuser_form").validate({
        rules: {
            name: {
                required: true,
            },
            nric: {
                required: true,
                minlength: 6,
                maxlength: 20
            },
            email: {
                required: true,
                email: true
            },
            cell_number: {
                required: true,
                number: true
            },
        /*     house_number:{
              required: true 
            },
            block_number:{
             required: true   
            },
            address:{
             required: true  
            }, */
            password: {
                minlength: 8,
                maxlength: 20,
            },
            confirm_password: {
                equalTo: "#password"
            }
        },
        messages: {
            name: {
                required: 'Please enter name',
            },
            nric: {
                required: 'Please enter nric number',
            },
            email: {
                required: 'Please enter email',
                email: 'Please enter correct email id'
            },
            cell_number: {
                required: 'Please enter mobile number',
                number: 'Please enter only number digit'
            },
          /*   house_number: {
                required: 'Please enter house number',
            },
            block_number: {
                required: 'Please enter block number',
            },
            address: {
                required: 'Please enter address',
            },*/
            password: {
//                required: 'Please enter password',
            },
            confirm_password: {
//                required: 'Please enter current password',
                equalTo: "Password and confirm password do not match"
            }
        }
    });


    jQuery("#security_visitor_reg").validate({
        rules: {
            name: {
                required: true,
            },
            nric: {
                required: true

            },
            mobile: {
                required: true,
                number: true,
                minlength: 8,
                maxlength: 15
            }
//            ,
//            car_file: {
//                required: true
//            }
//            car_model: {
//                required: true,
//            }

        },
        messages: {
            name: {
                required: 'Please enter name',
            },
            nric: {
                required: 'Please enter nric number',
            },

            mobile: {
                required: 'Please enter mobile number',
                number: 'Please enter only number digit'
            }
//            ,
//            car_file: {
//                required: "Please select image file"
//            }
//            car_model: {
//                required: 'Please enter car model',
//            },

        }
    });
    
    
     jQuery("#addunit-form").validate({
        rules: {
            house_number:{
              required: true 
            },
            unit_ptd:{
             required: true   
            },
            address:{
             required: true  
            }


        },
        messages: {
            house_number: {
                required: 'Please enter Unit Number',
            },
            unit_ptd: {
                required: 'Please enter PTD Number',
            },
            address: {
                required: 'Please enter Address'
            }
        }
    });
    
    


  jQuery("#addunituser-form").validate({
        rules: {
            name:{
              required: true 
            },
            nric:{
             required: true,
             minlength: 12        
            },
            email:{
             required: false,
             email:true
            },
            cell_number:{
              required: true       
            },           
           account_type:{
              required: true 
            }


        },
        messages: {
            name: {
                required: 'Please enter name',
            },
            nric: {
                required: 'Please enter nric number',
                remote: jQuery.validator.format("{0} is already taken.")
            },
            email: {
                required: 'Please enter address',
                email:'Please enter valid email'
            },
            cell_number:{
              required: 'Please enter mobile number'   
            },           
            account_type:{
                 required: 'Please select user type', 
            }
            

        }
    });



   jQuery("#addsecurity-form").validate({
        rules: {
            security_name:{
              required: true 
            },
            user_name:{
             required: true   
            },
            password: {
                required: true,   
                minlength: 8,
                maxlength: 20,
            },
            confirm_password: {
                equalTo: "#password"
            }


        },
        messages: {
            security_name: {
                required: 'Please enter Security Name',
            },
            user_name: {
                required: 'Please enter Username',
            },
            password: {
                required: 'Please enter password',
            },
            confirm_password: {
                required: 'Please enter current password',
                equalTo: "Password and confirm password do not match"
            }
        }
    });

     jQuery("#updatesecurity-form").validate({
        rules: {
            security_name:{
              required: true 
            },
            user_name:{
             required: true   
            },
            password: {
                minlength: 8,
                maxlength: 20,
            },
            confirm_password: {
                equalTo: "#password"
            }


        },
        messages: {
            security_name: {
                required: 'Please enter Security Name',
            },
            user_name: {
                required: 'Please enter Username',
            },
            password: {
                required: 'Please enter password',
            },
            confirm_password: {
                required: 'Please enter current password',
                equalTo: "Password and confirm password do not match"
            }
        }
    });   

});