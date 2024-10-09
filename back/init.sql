ALTER SCHEMA public OWNER TO realmeduser;

-- Assurer la propriété sur toutes les séquences existantes
ALTER SEQUENCE key_key_id_seq OWNER TO realmeduser;
-- Ajoute ici toutes les séquences spécifiques que tu dois ajuster
ALTER SEQUENCE your_other_sequence_name OWNER TO realmeduser;

-- Donner tous les droits à realmeduser pour le schéma public
GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO realmeduser;
GRANT ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA public TO realmeduser;
