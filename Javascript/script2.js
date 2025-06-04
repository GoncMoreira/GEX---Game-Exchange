
function addProductEvent() {
    const buttons = document.querySelectorAll(' button#buy')
    for (const button of buttons){
        button.addEventListener('click', function(event){
                    
            // Fetching Button value 
            let btnValue = button.value
            // jQuery Ajax Post Request 
            
            $.post('Action/addToCart.php', { 
                btnValue: btnValue 
            }, (response) => { 
                // response from PHP back-end 
                console.log(response)
            })
            // OR function() {console.log(this)}
                
        })
            
    }
}

function addProductWishEvent() {
    const buttons = document.querySelectorAll(' button#favourite')
    for (const button of buttons){
        button.addEventListener('click', function(event){
                    
            // Fetching Button value 
            let btnValue = button.value
            // jQuery Ajax Post Request 
            
            $.post('Action/addToWishList.php', { 
                btnValue: btnValue 
            }, (response) => { 
                // response from PHP back-end 
                console.log(response)
            })
            // OR function() {console.log(this)}
                
        })
            
    }
}
addProductEvent()
addProductWishEvent()


