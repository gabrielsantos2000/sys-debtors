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
    
    $('#vl_divida').mask('000.000,00', {reverse: true});
});

function checkForm() {
    validateForm.resetErros();

    validateForm.isNull($("#nm_titulo"));
    validateForm.isNull($("#nm_devedor"));
    validateForm.isNull($("#vl_divida"));
    validateForm.isNull($("#dt_divida"));
    validateForm.isNull($("#dt_vencimento"));
    validateForm.isNull($("#nm_natureza"));

    if(validateForm.canSubmit()) 
        return true;
    return false;
}