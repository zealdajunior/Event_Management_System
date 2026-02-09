# AI Assistant Implementation Guide

## Overview
This AI-powered chatbot helps users discover events, get recommendations based on their location, and answers questions about your event platform.

## Features

### 🤖 AI Capabilities
1. **Natural Language Understanding**: Understands user questions in conversational language
2. **Intent Detection**: Automatically detects what users want (search, booking, help, etc.)
3. **Location-Based Suggestions**: Uses user's geolocation to suggest nearby events
4. **Smart Event Matching**: Filters events by keywords, dates, categories, and location
5. **Contextual Responses**: Maintains conversation history for better context

### 📍 Location Features
- Automatic geolocation detection (with user permission)
- Radius-based event search (default 50km)
- Distance calculation using Haversine formula
- Supports queries like "events near me", "what's happening nearby"

### 🎯 Intent Recognition
The AI detects these intents:
- **search**: "find events", "show me concerts"
- **location_search**: "events near me", "what's nearby"
- **booking**: "buy tickets", "book event"
- **datetime_query**: "events today", "this weekend"
- **pricing**: "how much", "ticket cost"
- **help**: "how do I", "what is"

## Setup Instructions

### 1. Run Migration
```bash
cd "c:\Users\Zealda Junior\Desktop\Event\event_management"
php artisan migrate
```

### 2. Add OpenAI API Key
Add to `.env`:
```env
# AI Assistant Configuration
OPENAI_API_KEY=your-openai-api-key-here
OPENAI_MODEL=gpt-3.5-turbo
```

**Get your API key:**
1. Go to https://platform.openai.com/api-keys
2. Create account or login
3. Click "Create new secret key"
4. Copy and paste into `.env`

### 3. Clear Cache
```bash
php artisan config:clear
php artisan cache:clear
```

### 4. Install (If Using Alternative AI)
The system defaults to OpenAI, but you can switch to:
- **Anthropic Claude** (better understanding, safer)
- **Google Gemini** (free tier available)
- **Local AI** (Ollama, LM Studio)

## Usage

### For Users
1. **Chat Widget**: Fixed button bottom-right of every page
2. **Click to Open**: Opens chat window
3. **Ask Anything**: Type questions naturally
4. **Quick Actions**: Pre-built question buttons
5. **Event Cards**: Click suggested events to view details

### Example Queries
```
"Show me music events near me"
"What's happening this weekend?"
"Find concerts under $50"
"Events in downtown area"
"When is the jazz festival?"
"How do I buy tickets?"
```

### Location Permission
- Browser requests location permission on first use
- Users can deny and manually search
- Location stored in session for better suggestions

## How It Works

### Architecture
```
User Message → ChatController → AIAssistantService → OpenAI API
                    ↓
              Event Database
                    ↓
           AI Response + Events → User
```

### Response Flow
1. **User sends message** via chat widget
2. **Intent detected** (search, location, booking, etc.)
3. **Relevant events fetched** from database:
   - Approved events only
   - Location filtering (if coordinates provided)
   - Keyword matching
   - Date filtering
4. **Context built** for AI with event list
5. **OpenAI generates response** with event suggestions
6. **Event cards displayed** with clickable links

### Database Storage
- **chat_messages table**: Stores all conversations
- **session_id**: Links messages for guests
- **user_id**: Links messages for logged-in users
- **suggested_events**: JSON array of recommended event IDs
- **context**: Location, filters, preferences

## Customization

### Change AI Model
In `.env`:
```env
# Faster, cheaper (default)
OPENAI_MODEL=gpt-3.5-turbo

# More intelligent, better responses
OPENAI_MODEL=gpt-4

# Latest model
OPENAI_MODEL=gpt-4-turbo
```

### Adjust Search Radius
In `AIAssistantService.php` line 94:
```php
$radius = $context['radius'] ?? 50; // Change 50 to your preferred km
```

### Modify System Prompt
In `AIAssistantService.php` line 182-202, customize:
- AI personality
- Response style
- Guidelines
- Tone of voice

### Add More Intents
In `AIAssistantService.php` line 60-80, add patterns:
```php
if (preg_match('/\b(your|pattern|here)\b/', $message)) {
    return 'your_intent';
}
```

## Fallback Mode

If OpenAI API fails or key is missing:
- System uses **rule-based fallback**
- Still suggests events based on keywords
- No AI-generated text, but functional
- Logs errors for debugging

## Cost Optimization

### Tokens Used Per Request
- Average: ~500 tokens
- Cost: ~$0.0007 per message (GPT-3.5-turbo)
- 1,000 messages ≈ $0.70

### Reduce Costs
1. **Limit event context**: Show fewer events in prompt
2. **Shorter system prompt**: Remove verbose instructions
3. **Cache responses**: Store common queries
4. **Use GPT-3.5-turbo**: 10x cheaper than GPT-4

## Privacy & Security

### Data Stored
- ✅ User messages (for history)
- ✅ AI responses
- ✅ Location coordinates (session only)
- ✅ Suggested events

### NOT Stored
- ❌ Sensitive personal info
- ❌ Payment details
- ❌ Passwords

### User Privacy
- Location permission required
- Clear chat option available
- Session-based for guests
- GDPR compliant (deletable data)

## Troubleshooting

### Chat Widget Not Showing
1. Check if `@include('components.chat-widget')` is in layout
2. Verify Alpine.js is loaded
3. Clear browser cache

### AI Not Responding
1. Check `.env` has `OPENAI_API_KEY`
2. Run `php artisan config:clear`
3. Check logs: `storage/logs/laravel.log`
4. Verify API key is valid at platform.openai.com

### No Events Suggested
1. Ensure events are **approved** (`approval_status = 'approved'`)
2. Check event dates are in future
3. Verify venue has latitude/longitude for location search
4. Check keywords match event names/descriptions

### Location Not Working
1. Ensure HTTPS (geolocation requires secure connection)
2. Check browser permissions
3. Test with manual coordinates in request

## Advanced Features

### Add Conversation Memory
Store user preferences:
```php
// In AIAssistantService
protected function getUserPreferences($userId) {
    return UserPreference::where('user_id', $userId)->first();
}
```

### Multi-Language Support
Detect language and respond accordingly:
```php
if (preg_match('/[àáâãäå]/u', $message)) {
    $language = 'french';
}
```

### Voice Input
Add speech-to-text:
```javascript
const recognition = new webkitSpeechRecognition();
recognition.onresult = (event) => {
    messageInput = event.results[0][0].transcript;
    sendMessage();
};
```

### Event Booking via Chat
Process bookings directly:
```php
if ($intent === 'booking' && $event) {
    return "I can help you book! Click here: " . route('tickets.checkout', $event);
}
```

## Performance

### Optimization Tips
1. **Index database**: Add indexes to events table
2. **Cache event lists**: Cache popular searches
3. **Eager load**: Use `->with(['venue', 'category'])`
4. **Queue API calls**: Use Laravel queues for async
5. **Rate limiting**: Prevent API abuse

### Monitoring
Track in admin dashboard:
- Most common queries
- Average response time
- API costs
- User satisfaction
- Failed requests

## Future Enhancements

### Planned Features
- [ ] Multi-language support
- [ ] Voice input/output
- [ ] Image recognition (upload poster, find event)
- [ ] Calendar integration
- [ ] Ticket booking via chat
- [ ] Payment processing in chat
- [ ] Group chat for event attendees
- [ ] Event reminders via chat
- [ ] Real-time availability updates

---

**Ready to use!** The AI assistant is now active on all pages with the floating chat button.
