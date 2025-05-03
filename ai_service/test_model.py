from transformers import AutoTokenizer, AutoModelForSeq2SeqLM
import torch # Vérifier que torch est accessible

# Spécifier le modèle que nous voulons utiliser
# (On commence avec flan-t5-base, mais on pourrait mettre t5-small, etc.)
model_name = "google/flan-t5-base"
print(f"Tentative de chargement du modèle : {model_name}")

try:
    # Charger le tokenizer associé au modèle
    # Le tokenizer prépare le texte pour le modèle
    tokenizer = AutoTokenizer.from_pretrained(model_name)
    print("Tokenizer chargé avec succès.")

    # Charger le modèle pré-entraîné lui-même
    # AutoModelForSeq2SeqLM est adapté pour les tâches texte-vers-texte comme T5
    model = AutoModelForSeq2SeqLM.from_pretrained(model_name)
    print("Modèle chargé avec succès.")

    # === Testons une tâche simple ===
    # Texte d'entrée
    input_text = "translate English to French: Hello, how are you?"
    print(f"\nTexte d'entrée : {input_text}")

    # Préparer le texte d'entrée pour le modèle
    input_ids = tokenizer(input_text, return_tensors="pt").input_ids # pt pour PyTorch

    # Générer la sortie avec le modèle
    print("Génération de la sortie...")
    outputs = model.generate(input_ids, max_length=50) # max_length pour limiter la longueur

    # Décoder la sortie générée en texte lisible
    decoded_output = tokenizer.decode(outputs[0], skip_special_tokens=True)

    print(f"Sortie du modèle : {decoded_output}")
    print("\nTest terminé avec succès !")

except Exception as e:
    print(f"\nUne erreur est survenue : {e}")
    # Afficher plus de détails en cas d'erreur de chargement (souvent lié à la connexion ou espace disque)
    import traceback
    traceback.print_exc()