public class Match {
    private int id;
    private Adherents joueur1;
    private Adherents joueur2;
    private int scoreJoueur1;
    private int scoreJoueur2;

    public Match(int id, Adherents joueur1, Adherents joueur2, int scoreJoueur1, int scoreJoueur2) {
        this.id = id;
        this.joueur1 = joueur1;
        this.joueur2 = joueur2;
        this.scoreJoueur1 = scoreJoueur1;
        this.scoreJoueur2 = scoreJoueur2;
    }

    public int getId() {
        return id;
    }

    public void setId (int id) {
        this.id = id;
    }

    public Adherents getJoueur1() {
        return joueur1;
    }

    public void setJoueur1 (Adherents joueur1) {
        this.joueur1 = joueur1;
    }

    public Adherents getJoueur2() {
        return joueur2;
    }

    public void setJoueur2 (Adherents joueur2) {
        this.joueur2 = joueur2;
    }

    public int getScoreJoueur1(){
        return scoreJoueur1;
    }

    public void setScoreJoueur1(int scoreJoueur1) {
        this.scoreJoueur1 = scoreJoueur1;
    }

    public int getScoreJoueur2(){
        return scoreJoueur2;
    }

    public void setScoreJoueur2(int scoreJoueur2) {
        this.scoreJoueur2 = scoreJoueur2;
    }

    public boolean estTermine() {
        return scoreJoueur1 >= 0 && scoreJoueur2 >= 0;
    }

    public boolean estMatchNul() {
        return scoreJoueur1 == scoreJoueur2 && estTermine();
    }

    public Adherents getVainqueur() {
        if (estTermine()) {
            return (scoreJoueur1 > scoreJoueur2) ? joueur1 : joueur2;
        }
        return null; // Le match n'est pas terminé
    }

    public Adherents getPerdant() {
        if (estTermine()) {
            return (scoreJoueur1 < scoreJoueur2) ? joueur1 : joueur2;
        }
        return null; // Le match n'est pas terminé
    }

    public int getDifferenceScore() {
        return Math.abs(scoreJoueur1 - scoreJoueur2);
    }

    public int getScoreGagnant() {
        return 6; 
    }

    public boolean aAtteintScoreGagnant() {
        return (scoreJoueur1 >= getScoreGagnant() || scoreJoueur2 >= getScoreGagnant()) && estTermine();
    }

    public int getScoreTotal() {
        return scoreJoueur1 + scoreJoueur2;
    }
    
}
