const validateForm = new ValidateForm();

$(document).ready(function() {
    
    $(document).on("submit", "#newDebt", function(e) {
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
    validateForm.isNull($("#nm_titulo"));
    validateForm.isNull($("#nm_devedor"));
    validateForm.isNull($("#nr_cpf_cnpj"));
    validateForm.isNull($("#vl_divida"));
    validateForm.isNull($("#dt_divida"));
    validateForm.isNull($("#dt_vencimento"));
    validateForm.isNull($("#nm_natureza"));
    validateForm.isNull($("#ds_titulo"));

    if(validateForm.canSubmit()) 
        return true;
    return false;
}