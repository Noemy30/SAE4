import java.util.Date;
import java.util.List;

public class Tournoi {
    private int idTournoi;
    private String nom;
    private String lieu;
    private Date dateDebut;
    private Date dateFin;
    private String heureDebut;
    private String heureFin;
    private List<Adherents> participants; // Déclaration de la liste de participants
    private int placesDisponibles; // Déclaration du nombre de places disponibles


    public Tournoi(int idTournoi, String nom, String lieu, Date dateDebut, Date dateFin) {
        this.idTournoi = idTournoi;
        this.nom = nom;
        this.lieu = lieu;
        this.dateDebut = dateDebut;
        this.dateFin = dateFin;
    }

    // Getter pour l'ID
    public int getIdTournoi() {
        return idTournoi;
    }

    // Setter pour l'ID
    public void setIdTournoi(int idTournoi) {
        this.idTournoi = idTournoi;
    }

    // Getter pour le nom
    public String getNom() {
        return nom;
    }

    // Setter pour le nom
    public void setNom(String nom) {
        this.nom = nom;
    }

    // Getter pour le lieu
    public String getLieu() {
        return lieu;
    }

    // Setter pour le lieu
    public void setLieu(String lieu) {
        this.lieu = lieu;
    }

    // Getter pour la date de début
    public Date getDateDebut() {
        return dateDebut;
    }

    // Setter pour la date de début
    public void setDateDebut(Date dateDebut) {
        this.dateDebut = dateDebut;
    }

    // Getter pour la date de fin
    public Date getDateFin() {
        return dateFin;
    }

    // Setter pour la date de fin
    public void setDateFin(Date dateFin) {
        this.dateFin = dateFin;
    }

    public String getHeureDebut() {
        return heureDebut;
    }

    // Setter pour l'heure de début
    public void setHeureDebut(String heureDebut) {
        this.heureDebut = heureDebut;
    }

    // Getter pour l'heure de fin
    public String getHeureFin() {
        return heureFin;
    }

    // Setter pour l'heure de fin
    public void setHeureFin(String heureFin) {
        this.heureFin = heureFin;
    }

    public void saisirTournoi(Tournoi tournoi) {
        tournoi.add(tournoi);
    }

    private void add(Tournoi tournoi) {
    }

    public void inscrireAdherentsTournoi(Adherents adherents, Tournoi tournoi) {
        // Vérifiez la disponibilité et les contraintes de la compétition
        if (verifierDisponibiliteEtContraintes(adherents)) {
            // Si les conditions sont remplies, ajoutez l'adhérent à la liste des participants
            ajouterParticipant(adherents);
        }
    }

    public void validerDemandeInscription(Adherents adherents, Tournoi tournoi) {
        // Vérifiez que l'adhérent est correctement réparti dans les différents niveaux, etc.
        if (verifierRepartitionNiveaux(adherents, tournoi)) {
            // Si tout est en ordre, validez l'inscription de l'adhérent à la compétition
            tournoi.ajouterParticipant(adherents);
        }
    }

    public void gererProblemeTournoi(Tournoi tournoi, String probleme) {
    }

    public void annulerInscription(Adherents adherents, Tournoi tournoi) {
        tournoi.retirerParticipant(adherents);
    }

    public boolean verifierDisponibiliteEtContraintes(Adherents adherents) {
        return true;
    }

    public void ajouterParticipant(Adherents adherents) {
        if (placesDisponibles > 0) {
            participants.add(adherents);
            placesDisponibles--; 
        } else {
            System.out.println("Aucune place disponible.");
        }
    }

    // Méthode pour retirer un participant de la compétition
    public void retirerParticipant(Adherents adherents) {
        if (participants.remove(adherents)) {
            placesDisponibles++; 
        } else {
            System.out.println("Adhérent non trouvé dans la liste des participants.");
        }
    }

    // Méthode pour vérifier la répartition des niveaux
    public boolean verifierRepartitionNiveaux(Adherents adherents, Tournoi tournoi) {
        return true; 
    }

    public boolean estInscrit(Adherents adherent) {
        return participants.contains(adherent);
    }

    public int getNombreParticipants() {
        return participants.size();
    }

    public List<Adherents> getParticipants() {
        return participants;
    }

    public boolean estComplet() {
        return placesDisponibles == 0;
    }

    public double pourcentagePlacesDisponibles() {
        return (double) placesDisponibles / (participants.size() + placesDisponibles) * 100;
    }

    public int getPlacesDisponibles() {
        return placesDisponibles;
    }

    public void validerInscription(Adherents adherent) {
    }

    public void gererProbleme(String probleme) {
    }
    
}
