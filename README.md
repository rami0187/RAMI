# RACC Engineering Consulting — WordPress theme

Bilingual (English / العربية) WordPress theme for **RACC Engineering Consulting — شركة رموز الفكر للاستشارات الهندسية**, Jeddah.

- **Brand:** navy `#1c3249` and copper `#c08e74` (Pantone P 108-16 C / P 42-2 C), the RACC logo, and the RB (Riyad Bank) font for both Arabic and English.
- **Home page sections:** Hero with key figures, About us, the six Sectors & Services, a vision band, Projects (filterable by sector), Leadership, Accreditations, call to action, and Contact (form plus map).
- **Languages:** works with **Polylang**. Arabic pages switch to right-to-left automatically.
- **Contact form:** uses **Contact Form 7**. The theme creates an English form and an Arabic form, and both send to **info@romoz-alfekr.sa**.
- **Content:** taken from the RACC brochure. Everything can be edited from the WordPress admin.

```
racc-theme/          ← the theme (upload this)
brand/               ← original logo, colour sheet and brochure files
```

---

## 1. Install the theme

1. Download `racc-theme.zip`, or zip the `racc-theme` folder yourself.
2. In WordPress, go to **Appearance → Themes → Add New → Upload Theme**. Choose the zip, click **Install**, then **Activate**.
3. Go to **Settings → Permalinks** and click **Save** once. This makes `/projects/` URLs work.

## 2. Install the plugins

In **Plugins → Add New**, install and activate:

- **Polylang** (free)
- **Contact Form 7** (free)

## 3. Set up Polylang (English + Arabic)

1. **Languages → Languages**: add **English** first, then **العربية** (Arabic). Polylang marks Arabic as right-to-left automatically.
2. **Languages → Settings → URL modifications**: choose *"The language is set from the directory name in pretty permalinks"*. Then tick *"Hide URL language information for default language"*. English stays at `/` and Arabic lives at `/ar/`.
3. **Languages → Settings → Custom post types**: confirm that **Sectors & Services**, **Projects** and **Team** are ticked. The theme pre-ticks them.
4. Create the home page:
   - **Pages → Add New**: add a page titled *Home* with no content and **English** as its language.
   - In its **Languages** box, click **+** next to Arabic. This creates the Arabic version; title it *الرئيسية*.
   - **Settings → Reading**: set *Your homepage displays* to **A static page**, and choose *Home*. Polylang uses the Arabic translation automatically on `/ar/`.

The language button in the header (العربية / English) uses Polylang's links, so visitors land on the same page in the other language.

## 4. Contact Form 7

When Contact Form 7 is active, the theme automatically creates two forms the first time an administrator opens the dashboard:

- **RACC Contact — English**
- **RACC Contact — Arabic**, with Arabic labels and Arabic validation messages

Both send to **info@romoz-alfekr.sa**. Replying to an enquiry email goes straight to the visitor. The theme shows the right form for each language.

- To change the wording or recipient, go to **Contact → Contact Forms**, open the form, and use the *Mail* tab.
- To use a different form, go to **Appearance → Customize → RACC Theme → Contact form**.
- **Recommended:** install an SMTP plugin such as *WP Mail SMTP*, using your hosting email account. Many hosts silently drop mail sent with PHP's default mailer.

## 5. Edit the content

| What | Where |
|---|---|
| Phone, WhatsApp, email shown on the site, address, working hours, map location, social links | **Appearance → Customize → RACC Theme → Company & contact details** |
| Hero headline and paragraph, About text, vision quote (English and Arabic) | **Customize → RACC Theme → Hero & About text** |
| Hero, About, vision and call-to-action photos | **Customize → RACC Theme → Images** |
| Show or hide home page sections | **Customize → RACC Theme → Home page sections** |
| Brand colours, and the default language for visitors without Polylang | **Customize → RACC Theme → General & colours** |
| Header menu | **Appearance → Menus**: create one menu per language and assign both to *Primary menu*. With no menu, the theme shows links to each section. |

### Sectors, Projects and Team

These are three menus in the admin sidebar. Until you add your own posts, the site shows the content from the brochure: the six sectors, the leadership profile and sample projects.

- **Projects:** add your real projects with a title, description, **featured image**, sector, location, client and year. As soon as one project is published, **the sample projects disappear**. Add the Arabic translation with the **+** in the Languages box. Sector, year and featured image are copied across for you.
- **Sectors & Services:** add posts here only if you want to change the six default sectors. Use one line per service in *Services list*.
- **Team:** the consultant's profile is built in. Adding Team posts replaces it with your own list. The first member is shown as the large featured profile.

> **Important:** the six projects shown at first are placeholders, not real RACC projects. Replace them with your actual portfolio before launch. Logged-in editors see a reminder under the Projects section.

## Images

The default photos are free inspirational images from Unsplash: the Jeddah skyline, the Island Mosque on the corniche, engineers on site and construction cranes. They are loaded from Unsplash's servers. For best speed and reliability, upload your own photos, or download the Unsplash ones, and set them in **Customize → RACC Theme → Images** and as featured images on Projects. If an image ever fails to load, the theme shows a navy blueprint-style background instead, so the layout never looks broken.

## Without the plugins

The theme also works without Polylang and Contact Form 7. It then uses its own English/Arabic toggle (`?lang=ar`, remembered in a cookie) and a built-in form that sends to the address in **Customize → RACC Theme → Contact form**.

## Requirements

WordPress 6.2+ and PHP 7.4+. It was tested on WordPress 6.8 with Polylang 3.8 and Contact Form 7 6.1.
