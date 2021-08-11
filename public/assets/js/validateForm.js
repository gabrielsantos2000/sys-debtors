class ValidateForm {
    constructor() {
        this.erros = 0;
    }

    validate(form) {
        $(document).on("submit", form, function(e) {
            e.preventDefault();
        
            if(!checkForm()) {
                validateForm.alert("Preencha todos os campos!");
                return false;
            }
            
            $(this)[0].submit();
        });
    }

    isNull(element) {
        console.log(element)
        if(element.val() == "0" || element.val().length === 0)
            this.setErors(1);
    }

    canSubmit() {
        if(this.getErros() === 0)
            return true;
        return false;
    }

    setErors(erro) { 
        this.erros += erro;
    }

    getErros() {
        return this.erros;
    }

    resetErros()
    {
        this.erros = 0;
    }

    alert(msg){
        $(".alert-error").css("display", "block");
        $(".alert-message-error").html(msg);

        $(".alert-error").fadeTo(2000, 500).slideUp(500, function() {
            $(".alert-error").slideUp(500);
        });
    }

    sanitizeCpfCnpj(cpf_cnpf) {
        return cpf_cnpf.replace(".", "").replace(".", "").replace("-", "").replace("/", "");
    }

    maskCpfCnpj(element) {
        var options = {
            onKeyPress: function (cpf, ev, el, op) {
                var masks = ['000.000.000-000', '00.000.000/0000-00'];
                $(element).mask((cpf.length > 14) ? masks[1] : masks[0], op);
            }
        }
    
        $(element).length > 11 ? $(element).mask('00.000.000/0000-00', options) : $(element).mask('000.000.000-00#', options);
    }

    onlyNumbers(element) {
        $(element).keyup(function(e){
            if (/\D/g.test(this.value)) {
              this.value = this.value.replace(/\D/g, '');
            }
        });
    }
}