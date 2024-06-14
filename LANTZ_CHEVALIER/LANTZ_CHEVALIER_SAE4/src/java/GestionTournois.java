import java.util.List;

public class GestionTournois {

    private List<Tournoi> tournois;

    public GestionTournois(List<Tournoi> tournois) {
        this.tournois = tournois;
    }

    public void saisirCompetition(Tournoi tournoi) {
        tournois.add(tournoi);

    }

    public void inscrireAdherentACompetition(Adherents adherent, Tournoi competition) {
        if (competition.getPlacesDisponibles() > 0) {
            competition.ajouterParticipant(adherent);
        } else {
            System.out.println("Aucune place disponible.");
        }
    }

    public void validerDemandeInscription(Adherents adherent, Tournoi tournoi) {
        if (verifierRepartition(adherent, tournoi)) {
            tournoi.validerInscription(adherent);
        } else {
            System.out.println("Répartition incorrecte.");
        }
    }

    public void gererProblemeCompetition(Tournoi tournoi, String probleme) {
        tournoi.gererProbleme(probleme);
    }

    public void annulerInscription(Adherents adherent, Tournoi tournoi) {
        tournoi.retirerParticipant(adherent);
    }

    private boolean verifierRepartition(Adherents adherent, Tournoi tournoi) {
        return true;
    }

}
