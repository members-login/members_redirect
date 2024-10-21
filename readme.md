# Members: Redirect

With this extension, logged-in and non-logged-in users on different pages can be redirected to specific target pages (temporary redirect – 302).

See it live [here](https://members-login.dev/dashboard/).

## Logged-in users

If users are logged-in on the website, it may make sense to forward certain pages, such as "login", "registration" or "password lost".

A data source is required for this, e.g. “Get member”. Under “Content” -> “Parameters” a user feature should be selected here (e.g. ID or username), which is then written to the ```params``` pool.  The logged-in user can now be defined in the file ```extension.driver.php```:

```
$loggedinMember = $context['params']['ds-get-member.id'] ?? null;
```

You can then define the pages for which logged-in users are to be redirected:

``` php
if ( ($currentPage == 'login' or $currentPage == 'signup' or $currentPage == 'password-lost') and ($loggedinMember != null) ){
    header('Location: ' . $homepage . '', true, 302);

    exit;
}
```

## Non-logged-in users

Users who are not logged in can easily be redirected to the login page.

The secure page that the user has selected is passed as a GET parameter.

```?redirect_to=https%3A%2F%2Fexample.net%2Fdashboard%2F```

This allows the user to be forwarded directly to the desired secure page after successful login. The code for the login-form in your XSLT template:

``` xml
<xsl:if test="normalize-space(/data/params/url-redirect-to)">
    <input type="hidden" name="redirect value="{/data/params/url-redirect-to}" />
</xsl:if>
```

In the file ```extension.driver.php``` enter the page that is the secured page:

``` php
// Redirect non-loggedin members to log in page
if ( ($currentPage == 'dashboard' or $rootPage == 'dashboard' ) and $loggedinMember == null ) {
    ...
}
```

