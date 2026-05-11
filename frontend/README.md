# Morpheus Cloud Gaming - Simple UI Template

A clean, responsive UI template for a cloud gaming platform. Designed for junior developers - easy to understand and convert to React.

## Pages Included

| Page | File | Description |
|------|------|-------------|
| Login | `login.html` | Email + password form |
| Register | `register.html` | Account creation form |
| Dashboard | `index.html` | Home with subscription info, active session, connected accounts |
| Profile | `profile.html` | User info, subscription, Steam connection |
| Games | `games.html` | Responsive grid of game cards |
| Queue | `queue.html` | Queue position with progress bar |
| Session | `session.html` | Gaming session with video placeholder |
| Chat | `chat.html` | Conversations list + messages (mobile + desktop) |
| Admin | `admin.html` | Users table, active sessions table |

## Design System

### Colors
- Primary: `#2563eb` (blue)
- Background: `#f8fafc` (light gray)
- Text: `#111827` (dark)
- Accent: `#e5e7eb` (soft gray)
- Success: `#22c55e`
- Error: `#ef4444`

### Spacing
- Base unit: 8px
- Common values: 8px, 16px, 24px, 32px

### Components

#### Buttons
```html
<!-- Primary -->
<button class="btn btn-primary">Click me</button>

<!-- Secondary -->
<button class="btn btn-secondary">Cancel</button>

<!-- Danger -->
<button class="btn btn-danger">Delete</button>

<!-- Block (full width) -->
<button class="btn btn-primary btn-block">Submit</button>

<!-- Large -->
<button class="btn btn-primary btn-lg">Big Button</button>
```

#### Cards
```html
<div class="card">
  <div class="card-title">Title</div>
  <div class="card-subtitle">Subtitle</div>
  <p>Content goes here</p>
</div>
```

#### Forms
```html
<div class="form-group">
  <label class="form-label" for="email">Email</label>
  <input type="email" id="email" class="form-input" placeholder="your@email.com">
</div>
```

#### Alerts
```html
<div class="alert alert-success">Success message</div>
<div class="alert alert-error">Error message</div>
```

#### Tables
```html
<div class="table-container">
  <table class="table">
    <thead>
      <tr>
        <th>Header</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Data</td>
      </tr>
    </tbody>
  </table>
</div>
```

## Responsive Breakpoints

- Mobile: < 640px (1 column)
- Tablet: 640px - 1024px (2 columns)
- Desktop: 1024px - 1280px (3 columns)
- Large Desktop: > 1280px (4 columns)

## File Structure

```
morpheus-template/
├── styles.css      # All styles in one file
├── login.html      # Login page
├── register.html   # Register page
├── index.html      # Dashboard (home)
├── profile.html    # Profile page
├── games.html      # Games library
├── queue.html      # Queue status
├── session.html    # Gaming session
├── chat.html       # Chat interface
├── admin.html      # Admin dashboard
└── README.md       # This file
```

## Converting to React

1. **Create components** from reusable elements:
   - `Button.js` - All button variants
   - `Card.js` - Card component
   - `Input.js` - Form inputs
   - `Navbar.js` - Navigation bar
   - `Alert.js` - Alert messages

2. **Create page components**:
   - `LoginPage.js`
   - `RegisterPage.js`
   - `DashboardPage.js`
   - etc.

3. **Use CSS variables** in your React styles:
   ```css
   :root {
     --primary: #2563eb;
     --background: #f8fafc;
     /* ... */
   }
   ```

4. **Add routing** with React Router:
   ```jsx
   <Routes>
     <Route path="/login" element={<LoginPage />} />
     <Route path="/" element={<DashboardPage />} />
     {/* ... */}
   </Routes>
   ```

## Tips for Junior Developers

1. **Start with the CSS** - Understand the design system first
2. **Copy components** - Reuse the HTML/CSS patterns
3. **Test responsiveness** - Resize your browser to see changes
4. **Keep it simple** - Don't add complexity unless needed
5. **Use the mobile menu** - It's already implemented with simple JavaScript

## License

Free to use for any project.
