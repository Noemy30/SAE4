public class Adherents {
    private int id;
    private String nom;
    private String prenom;
    private String adresse;
    private String telephone;
    public int dateDeNaissance;

    // Constructeur
    public Adherents(int id, String nom, String prenom, String adresse, String telephone, int dateDeNaissance) {
        this.id = id;
        this.nom = nom;
        this.prenom = prenom;
        this.adresse = adresse;
        this.telephone = telephone;
        this.dateDeNaissance = dateDeNaissance;
    }

    // Getter et Setter pour l'ID
    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    // Getter et Setter pour le nom
    public String getNom() {
        return nom;
    }

    public void setNom(String nom) {
        this.nom = nom;
    }

    // Getter et Setter pour le prénom
    public String getPrenom() {
        return prenom;
    }

    public void setPrenom(String prenom) {
        this.prenom = prenom;
    }

    // Getter et Setter pour l'adresse
    public String getAdresse() {
        return adresse;
    }

    public void setAdresse(String adresse) {
        this.adresse = adresse;
    }

    // Getter et Setter pour le numéro de téléphone
    public String getTelephone() {
        return telephone;
    }

    public void setTelephone(String telephone) {
        this.telephone = telephone;
    }

    public int getDateDeNaissance() {
        return dateDeNaissance;
    }

    public void setDateDeNaissance(int dateDeNaissance) {
        this.dateDeNaissance = dateDeNaissance;
    }

    public void mettreAJourInformations(String nom, String prenom, String adresse, String telephone) {
        this.nom = nom;
        this.prenom = prenom;
        this.adresse = adresse;
        this.telephone = telephone;
    }

    // Méthode pour inscrire l'adhérent à une compétition
    public void sInscrireATournoi(Tournoi tournoi) {
    }

    // Méthode pour annuler l'inscription à une compétition
    public void annulerInscriptionATournoi(Tournoi tournoi) {
    }
}
