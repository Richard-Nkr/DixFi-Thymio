$("#new_edit_user_guest").on('submit', function(){
    if($("#user_guest_password").val() !== $("#verifpass").val()) {
        alert("Les deux mots de passe saisies sont différents");
        alert("Merci de renouveler l'opération");
        return false;
    }
})


$("#new_edit_teacher").on('submit', function(){
    if($("#teacher_password").val() !== $("#verifpass").val()) {
        alert("Les deux mots de passe saisies sont différents");
        alert("Merci de renouveler l'opération");
        return false;
    }
})


$("#new_edit_studentGroup").on('submit', function(){
    if($("#student_group_password").val() !== $("#verifpass").val()) {
        alert("Les deux mots de passe saisies sont différents");
        alert("Merci de renouveler l'opération");
        return false;
    }
})


function hideElement(id,hide) {
    let elt = document.getElementById();
    if (hide) {
        elt.style.visibility = "hidden";
    } else {
        elt.style.visibility = "visible";
    }
}