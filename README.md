# toyapp
Secureshare - A toy application to share jpeg files among multiple users, built to learn threshold cryptography
The app allows a jpeg image file to be encrypted and the secret key to be shared among n users of which a threshold(t) number of users should be present for decryption.
The app uses AES algorithm to encrypt the file using a randomly generated secret and the secret is then shared among n shareholders using Shamir's Secret Sharing Technique.
The key can be regenerated only if a threshold number of users collude and use their secret share.
