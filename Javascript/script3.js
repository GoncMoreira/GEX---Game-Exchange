
function removeProductWishEvent() {
    const buttons = document.querySelectorAll(' button#remove')
    for (const button of buttons){
        button.addEventListener('click', function(event){
                    
            // Fetching Button value 
            let btnValue = button.value
            // jQuery Ajax Post Request 
            $.post('Action/removefromWishList.php', { 
                btnValue: btnValue 
            }, (response) => { 
                // response from PHP back-end 
                console.log(response)
            })
            // OR function() {console.log(this)}
            button.parentElement.remove()    
        })
            
    }
}

removeProductWishEvent()