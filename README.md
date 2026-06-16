# Filter Abilities Lite

Filter Abilities Lite is a WordPress plugin that exposes core WordPress functionality as **Abilities API** abilities for AI agent interaction through the **Model Context Protocol (MCP)**. It gives MCP-compatible tools a structured way to read, create, and manage WordPress content, media, taxonomy data, migrations, site health information, and Gutenberg blocks.

## Requirements

- **WordPress 6.9+** (includes the Abilities API)
- **PHP 7.4+**
- A compatible **WordPress MCP Adapter** plugin configured to expose abilities over MCP

## Installation

1. Upload the `filter-abilities` folder to `wp-content/plugins/`.
2. Activate **Filter Abilities** from **Plugins > Installed Plugins** in WP Admin.
3. Install and configure a WordPress MCP adapter so your MCP client can call the registered abilities.

## How It Works

Filter Abilities Lite hooks into the WordPress Abilities API (`wp_abilities_api_init`) and registers abilities with JSON Schema inputs, callbacks, permissions, and MCP metadata.

The plugin uses the same modular foundation as the paid edition:

- **Core modules** load automatically and do not require settings.
- A custom `WP_Ability` subclass (`Filter_Abilities_MCP_Ability`) normalizes MCP request input for WordPress REST validation.
- Registered abilities are marked with `meta.mcp.public = true` so compatible MCP adapters can expose them.
- Three core WordPress abilities (`core/get-site-info`, `core/get-user-info`, `core/get-environment-info`) are also enabled for MCP access.

## Modules & Abilities

### Content Management (`filter-content`)

| Ability | Description |
|---|---|
| `filter/list-posts` | List posts by type with filtering, pagination, sorting, and search |
| `filter/get-post` | Get detailed post data including content, taxonomy terms, and ACF fields when ACF is active |
| `filter/get-post-by-url` | Look up a post by URL path or slug and return full post data |
| `filter/create-post` | Create a new post with optional author, taxonomy, and ACF field assignments when ACF is active |
| `filter/update-post` | Update an existing post's title, content, status, date, author, taxonomies, or ACF fields when ACF is active |
| `filter/delete-post` | Trash or permanently delete a post |
| `filter/bulk-post-actions` | Bulk publish, draft, trash, restore, or permanently delete multiple posts |

### Taxonomy Management (`filter-taxonomy`)

| Ability | Description |
|---|---|
| `filter/list-terms` | List terms for any public taxonomy with search, pagination, and hierarchy |
| `filter/manage-term` | Create, update, or delete a taxonomy term |

### Media Management (`filter-media`)

| Ability | Description |
|---|---|
| `filter/list-media` | List media library items with MIME type filtering and missing alt-text detection. Per-item output includes caption, description, parent post, and generated size URLs |
| `filter/upload-media` | Sideload up to 50 remote URLs into the media library with title, alt text, caption, description, parent post, featured image, and migration ID mapping support |

### Migration Tools (`filter-migration`)

| Ability | Description |
|---|---|
| `filter/rewrite-content` | Rewrite media references in post content, Gutenberg block attributes, image classes, gallery shortcodes, featured-image postmeta, and ACF image/gallery/file fields using a caller-supplied `media_map`. Defaults to `dry_run: true` for safety |

### Site Health (`filter-site`)

| Ability | Description |
|---|---|
| `filter/site-info` | Return site URL, WordPress version, active theme/plugins, post types, taxonomies, and detected modules |
| `filter/content-stats` | Return post counts by type/status, total media count, and total user count |

### Block Editing (`filter-blocks`)

| Ability | Description |
|---|---|
| `filter/get-post-blocks` | Read a post's Gutenberg content as a structured block tree with stable references for targeted edits |
| `filter/list-block-types` | List registered block types with schema and preference metadata |
| `filter/update-block` | Update one block's attributes or HTML while preserving block markup |
| `filter/insert-blocks` | Insert one or more blocks before, after, inside, or at the end of a target block location |
| `filter/delete-blocks` | Delete blocks by stable refs or indexes |
| `filter/mutate-block` | Insert, move, duplicate, replace, or remove blocks using stable refs and paths |
| `filter/batch-edit-blocks` | Apply multiple block edits in one checked operation |

## Pro Edition

The Pro edition includes everything in Lite plus additional modules for sites that use commercial or advanced plugins:

- ACF fields module reporting
- Yoast SEO management
- Gravity Forms management
- Filter AI content workflows
- Redirection management
- PersonalizeWP segments, rules, scoring, contacts, and activity
- PersonalizeWP with WooCommerce Teams analytics
- User-level permissions per ability
- Audit logs

## What Else Needs to Be in Place

For Filter Abilities Lite to be useful, the following must be set up on the WordPress site:

1. **WordPress 6.9+** - the Abilities API is a core feature starting in WordPress 6.9.
2. **MCP adapter plugin** - install and activate a compatible WordPress MCP adapter that bridges the Abilities API to an MCP transport.
3. **MCP client configuration** - configure your MCP client to connect to the WordPress site's MCP endpoint.
4. **Authentication** - configure the MCP adapter with appropriate authentication. Abilities that modify content require a user with sufficient WordPress capabilities.
5. **Optional plugins** - ACF can enrich some content and migration abilities when active. Other advanced integrations are available in the paid edition.

## License

GPL-2.0-or-later
