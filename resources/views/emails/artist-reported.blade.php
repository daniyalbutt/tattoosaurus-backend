<!DOCTYPE html>
<html><body style="font-family:Arial,sans-serif;color:#333;">
    <h2>New Artist Report</h2>
    <p><strong>Reported artist:</strong> {{ $report->artist->name }} (ID {{ $report->artist->id }})</p>
    <p><strong>Reported by:</strong> {{ $report->reporter->name }} ({{ $report->reporter->email }})</p>
    <p><strong>Reason:</strong> {{ $report->reason }}</p>
    @if($report->details)
        <p><strong>Details:</strong> {{ $report->details }}</p>
    @endif
    <p><strong>Submitted:</strong> {{ $report->created_at->format('M d, Y g:i a') }}</p>
    <hr>
    <p style="font-size:12px;color:#999;">Review this report in the admin panel.</p>
</body></html>