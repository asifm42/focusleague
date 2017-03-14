<tr>
    <td>
        <table class="footer" align="center" width="570" cellpadding="0" cellspacing="0">
            <tr>
                <td class="content-cell" align="center">
                    {{ Illuminate\Mail\Markdown::parse($slot) }}
                @if (isset($unsubscribe))
                    {{ Illuminate\Mail\Markdown::parse($unsubscribe) }}
                @endif
                </td>
            </tr>
        </table>
    </td>
</tr>
