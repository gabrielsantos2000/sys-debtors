const validateForm = new ValidateForm();

$(document).ready(function() {
    
    $(document).on("submit", "#newDebtor", function(e) {
        e.preventDefault();
    
        if(!checkForm()) {
            validateForm.alert("Preencha todos os campos!");
            return false;
        }
        
        $(this)[0].submit();
    });
    
    validateForm.maskCpfCnpj('#nr_cpf_cnpj');
    validateForm.onlyNumbers('#nr_logradouro');
});

function checkForm() {
    validateForm.resetErros();
    
    $("#nr_cpf_cnpj").val(
        validateForm.sanitizeCpfCnpj( 
            $("#nr_cpf_cnpj").val() 
        )
    );

    validateForm.isNull($("#nm_devedor"));
    validateForm.isNull($("#dt_nascimento"));
    validateForm.isNull($("#nr_cpf_cnpj"));
    validateForm.isNull($("#nm_logradouro"));
    validateForm.isNull($("#nr_logradouro"));
    validateForm.isNull($("#nm_bairro"));

    if(validateForm.canSubmit()) 
        return true;
    return false;
}