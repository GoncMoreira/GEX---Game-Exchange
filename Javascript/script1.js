// Função para atualizar o total
function updateTotal(value) {
    var totalElement = document.getElementById("total");
     var totalCurrent = parseFloat(totalElement.textContent); // Obtém o total atual
    var NewTotal = totalCurrent + value; // Calcula o novo total
    totalElement.textContent = NewTotal + "€"; // Atualiza o elemento HTML com o novo total
}


function removeProductEvent() {
    const buttons = document.querySelectorAll('button#remove')

        for (const button of buttons){
        
            button.addEventListener('click', function(event){
            var price = parseFloat(this.parentNode.querySelector("#price").textContent.replace(/[^0-9.-]+/g, ""));
            // Fetching Button value
            let btnValue = button.value
            // jQuery Ajax Post Request
            $.post('Action/removefromCart.php', {
                btnValue: btnValue
            }, (response) => {
                // response from PHP back-end
                console.log(response)
            })
            // OR function() {console.log(this)}
            button.parentElement.remove()

            updateTotal(-price);

            var totalElement = document.getElementById("total");
            var totalCurrent = parseFloat(totalElement.textContent); // Obtém o total atual
            if (totalCurrent === 0) {
                var purchaseButton = document.getElementById("purchase_button");
                purchaseButton.style.display = "none"; // Oculta o botão se o total for 0
            }
        })
    

}

}

removeProductEvent()
