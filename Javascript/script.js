

function addToShoppingCart(){
// Button DOM 
    //const btn = document.getElementById('buy')
    const btn = document.querySelector('button#buy')
    if (btn === null) {return;}
    // Adding event listener to button 
    btn.addEventListener('click', function() { 
        console.log(btn.innerHTML)
    
        // Fetching Button value 
        let btnValue = btn.value
    
        // jQuery Ajax Post Request 
        $.post('Action/addToCart.php', { 
            btnValue: btnValue 
        }, (response) => { 
            // response from PHP back-end 
            console.log(response)
        })
    })
}



function addFavourite(){
    const btn = document.querySelector('button#favourite')
    if (btn === null) {return;}
    // Adding event listener to button 
    btn.addEventListener('click', function() { 
        console.log(btn.innerHTML)
    
        // Fetching Button value 
        let btnValue = btn.value
    
        // jQuery Ajax Post Request 
        $.post('Action/addToWishList.php', { 
            btnValue: btnValue 
        }, (response) => { 
            // response from PHP back-end 
            console.log(response)
        })
    })

}

addToShoppingCart()
addFavourite()
