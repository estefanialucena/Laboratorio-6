function validation (){

    // get all input elements (name, email, password, confirm)
    var elements = document.querySelectorAll("input");
    
    // initialise valid elements
    var valid_elements = [];

    // iterate through input elements
    elements.forEach(element => {
        
        // create error message for empty fields in red
        var required_text = document.createElement("p");
        required_text.appendChild(document.createTextNode("Rellene este campo"));
        required_text.style.color = "red";

        // create validation error message in red
        var error_text = document.createElement('p');
        if (element.type === "text") {
            var validation_msg = "No puede contener números ni símbolos"
        }
        else if ( element.type === "email" ) {
            var validation_msg = "Email inválido"
        }
        else if (element.type === "password") {
            if (element.name === "password" ) {
                var validation_msg = "Debe tener entre 4 y 8 caracteres"
            }
            else if (element.name === "confirm") {
                var validation_msg = "Las contraseñas no coinciden"
            }
        }
        error_text.appendChild(document.createTextNode(validation_msg));
        error_text.style.color = "red";

        // check if input field is empty
        const isEmpty = str => !str.trim().length;
        element.addEventListener("input", function() {
            // if it is empty
            if ( isEmpty(this.value) ) {
                // remove validation error message (if it exists)
                if (document.body.contains(error_text)){
                    element.parentNode.removeChild(error_text);
                }

                // show requirement error message
                element.parentNode.appendChild(required_text, element);

                // change element border color to red
                element.style.border = "2px solid red";  
            }
            // if it is not empty
            else {
                
                // remove requirement error message (if it exists)
                if (document.body.contains(required_text)){
                    element.parentNode.removeChild(required_text);
                }
          
                // get condition to change validation message for confirmation field
                if ( element.name === "confirm" ) {
                    condition = (document.getElementById('password').value !== element.value);
                }
                else {
                    condition = (element.checkValidity() === false);
                }

                // if input is invalid
                if ( condition ) {
                    // show validation error message (if it exists)
                    element.parentNode.appendChild(error_text, element);

                    // change element border color to red
                    element.style.border = "2px solid red";
                    
                    // remove field from valid elements
                    const index = valid_elements.indexOf(element.name);
                    if (index > -1) { 
                        valid_elements.splice(index, 1); 
                    }
                }
                // if input is valid
                else {
                    // remove validation error message (if it exists)
                    if (document.body.contains(error_text)){
                        element.parentNode.removeChild(error_text);
                    }
                    
                    // change element border color to green
                    element.style.border = "2px solid green";
                    
                    // add field to valid elements
                    if ( !valid_elements.includes(element.name) ){
                        valid_elements.push(element.name)
                    }
                }
            }
        });

    });

    document.getElementById('submit-button').addEventListener("click", function(event){

        const all_elements = ["name", "first-surname", "second-surname", "email", "password", "confirm"]
        if ( all_elements.every(field => valid_elements.includes(field)) ) {
            alert("La inscripción se ha realizado con éxito.");
            return true;
        }
        else {
            alert("Uno o más campos no son válidos, por favor revíselos.");
            event.preventDefault();
            return false;
        }
    });

}

window.onload = validation;