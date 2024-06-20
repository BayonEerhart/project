document.getElementById("displayon").style.display = "block";


console.log("it runss");

amount = 1
document.getElementById("addBox").addEventListener("click", function addBox() { 
    if (amount < 4) {

        console.log("run");
        
        amount++
        document.getElementById("inv"+ amount).style.display = "block";
        document.getElementById("Tinv"+ amount).style.display = "block";
        document.getElementById("value").value = amount;

        if (amount == 4) {
            document.getElementById("addBox").style.display = "contents";
            document.getElementById("addBox").disabled = true;

        } else {
            document.getElementById("addBox").style.display = "";
            document.getElementById("addBox").disabled = false;
        }
        if (amount == 1) {
            document.getElementById("removeBox").style.display = "contents";
            document.getElementById("removeBox").disabled = true;
        } else {
            document.getElementById("removeBox").style.display = "";
            document.getElementById("removeBox").disabled = false;
        }
    }

} );


document.getElementById("removeBox").addEventListener("click", function removeBox() { 
    if (amount > 1) {
        
        document.getElementById("inv" + amount ).style.display = "none";
        document.getElementById("Tinv" + amount ).style.display = "none";

        amount--
        document.getElementById("value").value = amount;
        if (amount == 1) {
            document.getElementById("removeBox").style.display = "contents";
            document.getElementById("removeBox").disabled = true;
        } else {
            document.getElementById("removeBox").style.display = "";
            document.getElementById("removeBox").disabled = false;
        }
        if (amount == 4) {
            document.getElementById("addBox").style.display = "contents";
            document.getElementById("addBox").disabled = true;

        } else {
            document.getElementById("addBox").style.display = "";
            document.getElementById("addBox").disabled = false;
        }
    }

} );