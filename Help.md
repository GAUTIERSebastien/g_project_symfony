# Help

## Installer le certificat pour le serveur

```bash
symfony server:ca:install
```

## Lancer le serveur

```bash
symfony server:start -d
```

## Arrêter le serveur

```bash
symfony server:stop
```

## Isérer un utilisateur dans la base de données

```sql
INSERT INTO `user` (`id`, `email`, `roles`, `password`) VALUES (NULL, "seb@seb.com", '[\"ROLE_USER"\]', "$2y$13$7IpuT/MEnO8SAoHO20I2fOQDlJreEr498AkrWYwfpQfKYZI6OYSBG");
```

## Hacher un mot de passe

```bash
symfony console security:hash-password
```
