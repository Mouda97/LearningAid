from flask import Flask, request, jsonify
import torch # Importer torch
from transformers import AutoTokenizer, AutoModelForSeq2SeqLM # Importer les classes de Hugging Face
import traceback # Pour afficher les erreurs

# --- Chargement du Modèle (fait une seule fois au démarrage) ---
MODEL_NAME = "google/flan-t5-base"
tokenizer = None
model = None

def load_model():
    """Charge le tokenizer et le modèle au démarrage."""
    global tokenizer, model # Indique qu'on modifie les variables globales
    print(f"Chargement du tokenizer : {MODEL_NAME}...")
    try:
        tokenizer = AutoTokenizer.from_pretrained(MODEL_NAME)
        print("Tokenizer chargé.")
        print(f"Chargement du modèle : {MODEL_NAME}...")
        # Utiliser torch.device pour potentiellement utiliser le GPU si disponible (optionnel)
        # device = torch.device("cuda" if torch.cuda.is_available() else "cpu")
        # print(f"Utilisation du device : {device}")
        # model = AutoModelForSeq2SeqLM.from_pretrained(MODEL_NAME).to(device)
        # Pour simplifier pour l'instant, on utilise le CPU par défaut :
        model = AutoModelForSeq2SeqLM.from_pretrained(MODEL_NAME)
        print("Modèle chargé.")
    except Exception as e:
        print(f"ERREUR lors du chargement du modèle/tokenizer : {e}")
        tokenizer = None
        model = None
        traceback.print_exc()

# Charger le modèle dès l'importation du module
load_model()
# --------------------------------------------------------------


# Initialiser l'application Flask
app = Flask(__name__)

@app.route('/')
def home():
    if model and tokenizer:
        return "AI Service Flask (avec modèle T5 chargé) est en cours d'exécution !"
    else:
        return "AI Service Flask démarré, mais ERREUR lors du chargement du modèle T5.", 500

# --- Route pour la génération de texte ---
@app.route('/generate', methods=['POST']) # Accepte uniquement les requêtes POST
def generate():
    if not model or not tokenizer:
        app.logger.error("Modèle AI non chargé lors de la requête /generate.")
        return jsonify({"error": "Modèle AI non chargé."}), 500

    data = request.get_json()
    if not data:
        app.logger.error("Requête invalide reçue sur /generate (pas de JSON).")
        return jsonify({"error": "Requête invalide, JSON attendu."}), 400

    instruction = data.get('instruction')
    text = data.get('text')

    # === AJOUTER CES LOGS ===
    app.logger.info(f"Requête reçue sur /generate.")
    app.logger.info(f"  Instruction reçue : {instruction}")
    app.logger.info(f"  Début du texte reçu : {text[:150]}...") # Affiche les 150 premiers caractères
    # =======================

    if not instruction or not text:
        app.logger.error("Instruction ou texte manquant dans la requête JSON.")
        return jsonify({"error": "Les clés 'instruction' et 'text' sont requises dans le JSON."}), 400

    input_text = f"{instruction}{text}"

    # Dans la fonction generate() de ai_service/app.py

    try:
        app.logger.info("Tokenisation de l'entrée...")
        input_ids = tokenizer(input_text, return_tensors="pt", max_length=1024, truncation=True).input_ids

        app.logger.info("Génération de la sortie...")
        output_ids = model.generate(input_ids, max_length=512, num_beams=4, early_stopping=True)

        app.logger.info("Décodage de la sortie...")
        # 1. Décoder D'ABORD
        generated_text = tokenizer.decode(output_ids[0], skip_special_tokens=True)

        # 2. Log APRÈS succès du décodage
        app.logger.info(f"Texte généré brut (avant JSON response) : {generated_text[:150]}...")

        # 3. Retourner le succès
        return jsonify({"generated_text": generated_text})

    except Exception as e:
        # En cas d'erreur pendant try:, logguer l'erreur spécifique
        app.logger.error(f"ERREUR pendant la génération/décodage : {str(e)}")
        traceback.print_exc() # Affiche la trace complète dans le terminal Flask
        # Retourner un message d'erreur plus précis à Laravel
        return jsonify({"error": f"Erreur interne du serveur lors de la génération/décodage: {str(e)}"}), 500


# Lancer le serveur de développement Flask
if __name__ == '__main__':
    app.run(host='127.0.0.1', port=5001, debug=True) # `debug=True` recharge si on modifie app.py