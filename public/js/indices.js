
    let compteur = 0;
    function myFunction() {
    compteur++;
    document.getElementById("num".concat(compteur.toString())).style.display = "inline";
}
    function myFunction2() {
    if(document.getElementById("correction").style.display === "inline"){
    document.getElementById("correction").style.display = "none";
    document.getElementById("button_js").textContent = "Voir la correction";
}else{
    document.getElementById("correction").style.display = "inline";
    document.getElementById("button_js").textContent = "Cacher la correction";
}
}