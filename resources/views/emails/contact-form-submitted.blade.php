<x-mail::message>
# Nouveau message via le formulaire de contact

**Nom :** {{ $senderName }}
**Email :** {{ $senderEmail }}
**Sujet :** {{ $contactSubject }}

{{ $body }}

---

Tu peux répondre directement à cet email, la réponse partira vers {{ $senderEmail }}.
</x-mail::message>
