Submissions (Sedgemore) — Admin guide

Overview

This theme stores form enquiries submitted from the Home Review form in WordPress so non-technical staff can manage them.

Where to find submissions

- WP Admin -> Submissions
  - Click any entry to open it.
  - The "Submission details" box shows first/last name, email, topic, submitted at, mail status and the message text.
  - Use the "Copy message" button to copy the message text to clipboard.

Sending follow-up emails

- Open a submission and check "Mark for follow-up (send follow-up email on save)".
- Click "Update" (Save). The system will send one follow-up email and mark the submission as "Follow-up sent".
- Follow-up behavior and template are configurable in Settings (see below).

Exporting submissions

- To export all submissions: WP Admin -> Submissions -> Export -> Download CSV
- To export specific submissions: on the Submissions list select rows, choose "Export selected as CSV" from Bulk actions, click Apply.

Settings (configure notification and follow-up behavior)

- WP Admin -> Submissions -> Settings
  - Notification email: the address where new enquiry emails are sent.
  - CC address (optional): a CC recipient for notification emails.
  - Subject prefix: text that prefixes notification subject lines.
  - Follow-up subject: subject for follow-up emails sent to submitters.
  - Follow-up body: plain-text body or placeholders for the simple follow-up body.
  - Use HTML follow-up template: when enabled, the HTML template below is used.
  - HTML template: editable HTML template. Available placeholders:
    - {first_name}
    - {last_name}
    - {message}
    - {topic}
    - {site_name}
    - {site_url}
    - {site_logo_url} (URL of the configured Custom Logo)
    - {admin_email}

Notes and tips

- The follow-up email is sent once per submission. The follow-up attempt is logged and the admin column shows sent/not-sent.
- The HTML template is inserted as-is into the email body. If you include inline CSS, keep it simple for best compatibility across email clients.
- If you need richer features (scheduled follow-ups, templates per topic, or an audit screen), tell me which workflow you'd prefer and I can extend this.

Security & permissions

- Only users with administrator-like permissions can access Export and Settings pages.
- Submissions are stored as private posts (not publicly visible).

Support

If anything behaves unexpectedly (no email delivered, missing fields), let me know the submission ID and I'll inspect logs and meta for that entry.
