function confirmDelete(commentId) {
    var result = confirm("Êtes-vous sûr de supprimer ce commentaire?");
    
    if (result) {
        // Si l'utilisateur clique sur OK, soumettez le formulaire de suppression
        document.getElementById(commentId).submit();
    } else {
        // Si l'utilisateur clique sur Annuler, ne faites rien
    }
}