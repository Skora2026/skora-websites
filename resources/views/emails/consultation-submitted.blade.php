<!DOCTYPE html>
<html>
<head>
    <title>New Inquiry Submitted</title>
</head>
<body>
    <h2>New Inquiry Request</h2>
    <p>A new Inquiry form has been submitted on {{ now()->format('d M Y H:i') }}.</p>
    
    <table style="border-collapse: collapse; width: 100%;">
        <tr><td style="border: 1px solid #ddd; padding: 8px;"><strong>Name:</strong></td><td style="border: 1px solid #ddd; padding: 8px;">{{ $consult->name }}</td></tr>
        <tr><td style="border: 1px solid #ddd; padding: 8px;"><strong>Phone:</strong></td><td style="border: 1px solid #ddd; padding: 8px;">{{ $consult->phone }}</td></tr>
        <tr><td style="border: 1px solid #ddd; padding: 8px;"><strong>Interests:</strong></td><td style="border: 1px solid #ddd; padding: 8px;">{{ implode(', ', $consult->interests) }}</td></tr>
        <tr><td style="border: 1px solid #ddd; padding: 8px;"><strong>Budget:</strong></td><td style="border: 1px solid #ddd; padding: 8px;">{{ $consult->budget ?? 'N/A' }}</td></tr>
    </table>
    
    <p>Log Details: Submission ID #{{ $consult->id }} | IP: {{ request()->ip() }}</p>
    
    <p>Best regards,<br>{{ settings('company_name') }} Team</p>
</body>
</html>