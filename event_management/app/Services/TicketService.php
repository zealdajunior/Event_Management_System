
namespace App\Services;

use App\Models\Ticket;
use App\Models\Event;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TicketService
{
    /**
     * Create tickets for an event
     *
     * @param Event $event
     * @param array $ticketData
     * @return bool
     */
    public function createTicketsForEvent(Event $event, array $ticketData): bool
    {
        try {
            DB::beginTransaction();

            foreach ($ticketData as $data) {
                $event->tickets()->create([
                    'type' => $data['type'],
                    'price' => $data['price'],
                    'quantity' => $data['quantity'],
                    'description' => $data['description'] ?? null,
                ]);
            }

            DB::commit();
            Log::info("Tickets created for event: {$event->name}");
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Failed to create tickets for event: {$event->name}", [
                'error' => $e->getMessage(),
                'data' => $ticketData
            ]);
            return false;
        }
    }

    /**
     * Update ticket availability
     *
     * @param Ticket $ticket
     * @param int $quantityChange
     * @return bool
     */
    public function updateTicketAvailability(Ticket $ticket, int $quantityChange): bool
    {
        try {
            $newQuantity = $ticket->quantity + $quantityChange;

            if ($newQuantity < 0) {
                throw new \Exception('Ticket quantity cannot be negative');
            }

            $ticket->update(['quantity' => $newQuantity]);
            Log::info("Ticket availability updated: {$ticket->type}", [
                'event_id' => $ticket->event_id,
                'change' => $quantityChange,
                'new_quantity' => $newQuantity
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error("Failed to update ticket availability", [
                'ticket_id' => $ticket->id,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Check if ticket is available
     *
     * @param Ticket $ticket
     * @param int $requestedQuantity
     * @return bool
     */
    public function isTicketAvailable(Ticket $ticket, int $requestedQuantity = 1): bool
    {
        return $ticket->quantity >= $requestedQuantity;
    }

    /**
     * Get available tickets for an event
     *
     * @param Event $event
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAvailableTickets(Event $event)
    {
        return $event->tickets()->where('quantity', '>', 0)->get();
    }

    /**
     * Calculate total revenue for an event
     *
     * @param Event $event
     * @return float
     */
    public function calculateEventRevenue(Event $event): float
    {
        return $event->bookings()
            ->where('status', 'confirmed')
            ->sum(DB::raw('tickets.price'));
    }

    /**
     * Get ticket sales statistics
     *
     * @param Event $event
     * @return array
     */
    public function getTicketSalesStats(Event $event): array
    {
        $totalTickets = $event->tickets()->sum('quantity');
        $soldTickets = $event->bookings()->where('status', 'confirmed')->count();
        $availableTickets = $totalTickets - $soldTickets;
        $revenue = $this->calculateEventRevenue($event);

        return [
            'total_tickets' => $totalTickets,
            'sold_tickets' => $soldTickets,
            'available_tickets' => $availableTickets,
            'revenue' => $revenue,
            'occupancy_rate' => $totalTickets > 0 ? round(($soldTickets / $totalTickets) * 100, 2) : 0
        ];
    }
}
