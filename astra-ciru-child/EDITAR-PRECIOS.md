# Cómo editar los precios de inscripciones

Los precios se configuran en el archivo: **`precios-config.json`**

## Editar desde Hostinger

### Opción 1: File Manager

1. **Hostinger → File Manager**
2. Navegar a: `public_html/wp-content/themes/astra-ciru-child/`
3. Buscar archivo: `precios-config.json`
4. Clic derecho → **Edit** (o doble clic)
5. Editar los valores que necesites
6. **Save**
7. Refrescar la página web (Ctrl+Shift+R)

### Opción 2: FTP (FileZilla)

1. Conectar por FTP a Hostinger
2. Ir a: `/public_html/wp-content/themes/astra-ciru-child/`
3. Descargar `precios-config.json`
4. Editar con tu editor favorito (VS Code, Notepad++, etc.)
5. Subir el archivo editado (reemplazar)

## Qué puedes editar

```json
{
  "cirugia": [
    {
      "titulo": "Socio SCC",                    ← Nombre de la tarifa
      "subtitulo": "Socio activo de la SCC",    ← Descripción
      "precio": "250",                          ← Precio (solo número)
      "moneda": "USD",                          ← Moneda: USD o UYU
      "periodo": "precio anticipado",           ← Etiqueta del precio
      "precio_regular": "300",                  ← Precio tachado (dejar "" si no hay)
      "featured": false,                        ← true = fondo oscuro destacado
      "badge": null,                            ← Etiqueta esquina: "Más elegido" o null
      "features": [                             ← Lista de beneficios
        "Acceso a todas las sesiones",
        "Material digital",
        "Coffee breaks",
        "Certificado"
      ],
      "href": "#contacto"                       ← Link del botón
    }
  ]
}
```

## Ejemplo: cambiar precio de "No Socio" a USD 350

Buscar en el JSON:

```json
{
  "titulo": "No Socio",
  "precio": "000",  ← CAMBIAR a "350"
```

Cambiar a:

```json
{
  "titulo": "No Socio",
  "precio": "350",
```

Guardar y refrescar la web.

## Estructura del JSON

El archivo tiene 3 secciones:

- **`cirugia`** → Congreso de Cirugía & Residentes (3 tarifas)
- **`enfermeria`** → Jornadas de Enfermería (2 tarifas)
- **`instrumentacion`** → Jornadas de Instrumentación (2 tarifas)

Cada sección es un array `[]` con objetos `{}` (uno por cada tarifa).

## Tips

- **NO borrar comas** entre campos (el JSON se rompe)
- **Usar comillas dobles** `"` para todos los textos
- Para agregar más beneficios: copiar una línea existente y cambiarla
- Para quitar beneficios: borrar la línea completa (incluida la coma)

## Validar JSON

Si editaste y la página muestra vacía:
1. Copiar todo el contenido del archivo
2. Ir a: https://jsonlint.com/
3. Pegar y clic en "Validate JSON"
4. Arreglar errores que muestre (generalmente comas de más o faltantes)

---

**Cualquier duda:** editar desde local y probar con `make up` antes de subir a producción.
