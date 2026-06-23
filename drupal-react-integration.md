# Decoupled Drupal & React Website Architecture
**Stack:** Drupal (Backend CMS) + React/Next.js (SSG Frontend) + Tailwind CSS (Styling)

---

## 1. Dynamic Tailwind Configuration (`tailwind.config.js`)
Maps Tailwind utility classes to CSS variables that are injected dynamically at runtime.

```javascript
module.exports = {
  content: [
    "./src/**/*.{js,ts,jsx,tsx,mdx}",
  ],
  theme: {
    extend: {
      colors: {
        brand: {
          primary: 'var(--brand-primary)',
          secondary: 'var(--brand-secondary)',
          accent: 'var(--brand-accent)',
        },
      },
      borderRadius: {
        'brand-ui': 'var(--brand-radius)',
      }
    },
  },
  plugins: [],
}
```

---

## 2. Local Fallback Configuration (`src/config/theme.defaults.js`)
Ensures data integrity and fallback layout rules if the API returns malformed values or drops offline.

```javascript
export const DEFAULT_THEME = {
  primary: '#3b82f6',   
  secondary: '#1e3a8a', 
  radius: '4px',        
};

export function validateTheme(apiData) {
  if (!apiData) return DEFAULT_THEME;

  const isHex = (val) => /^#[0-9A-Fa-f]{3,8}\$/.test(val);
  const isSize = (val) => /^[0-9]+(px|rem|em|%)\$/.test(val);

  return {
    primary: isHex(apiData.primary) ? apiData.primary : DEFAULT_THEME.primary,
    secondary: isHex(apiData.secondary) ? apiData.secondary : DEFAULT_THEME.secondary,
    radius: isSize(apiData.radius) ? apiData.radius : DEFAULT_THEME.radius,
  };
}
```

---

## 3. Secure API & OAuth Data Layer (`src/lib/drupal.js`)
Authenticates securely via Simple OAuth client credentials and fetches tokens from the custom JSON:API Extras endpoint.

```javascript
import { DEFAULT_THEME, validateTheme } from '@/config/theme.defaults';

async function getAccessToken() {
  const response = await fetch(`${process.env.DRUPAL_BASE_URL}/oauth/token`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: new URLSearchParams({
      grant_type: 'client_credentials',
      client_id: process.env.DRUPAL_CLIENT_ID,
      client_secret: process.env.DRUPAL_CLIENT_SECRET,
    }),
  });

  const data = await response.json();
  return data.access_token;
}

export async function getDrupalThemeSettings() {
  try {
    const token = await getAccessToken();
    const controller = new AbortController();
    const timeoutId = setTimeout(() => controller.abort(), 4000); 

    const response = await fetch(`${process.env.DRUPAL_BASE_URL}/jsonapi/theme`, {
      headers: { 'Authorization': `Bearer ${token}` },
      signal: controller.signal,
      next: { revalidate: 3600 }
    });
    
    clearTimeout(timeoutId);

    if (!response.ok) throw new Error(`Drupal responded with status: ${response.status}`);

    const json = await response.json();
    return validateTheme(json.data.attributes);

  } catch (error) {
    console.error('Failed to fetch Drupal theme tokens. Using local defaults.', error);
    return DEFAULT_THEME; 
  }
}
```

---

## 4. Root Application Layout (`src/app/layout.js`)
Injects the architecture tokens straight into the global DOM context using dynamic inline variables.

```jsx
import './globals.css';
import { getDrupalThemeSettings } from '@/lib/drupal';

export default async function RootLayout({ children }) {
  const theme = await getDrupalThemeSettings();

  const cssVariables = {
    '--brand-primary': theme.primary,
    '--brand-secondary': theme.secondary,
    '--brand-radius': theme.radius,
  };

  return (
    <html lang="en">
      <body style={cssVariables} className="bg-slate-50 antialiased">
        {children}
      </body>
    </html>
  );
}
```

---

## 5. Live Preview API Handler (`src/app/api/preview/route.js`)
Bypasses the static page generation layout rules when an editor accesses the secure live preview route.

```javascript
import { draftMode } from 'next/headers';
import { redirect } from 'next/navigation';

export async function GET(request) {
  const { searchParams } = new URL(request.url);
  const secret = searchParams.get('secret');
  const slug = searchParams.get('slug');

  if (secret !== process.env.DRUPAL_PREVIEW_SECRET || !slug) {
    return new Response('Invalid token', { status: 401 });
  }

  const draft = await draftMode();
  draft.enable();

  redirect(slug);
}
```
