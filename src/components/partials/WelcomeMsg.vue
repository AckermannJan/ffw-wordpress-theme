<template>
    <div class="text-center dottedBorder mb-5">
        <h1 class="headline font-italic font-weight-bold mb-5">
            Unsere Freizeit für Ihre Sicherheit -<br>
            Seit 140 Jahren
        </h1>
        <p>Wir freuen uns, dass Sie den Weg auf unsere Webseite gefunden haben.<br>
            Schauen Sie sich um und entdecken Sie die Vielfalt der Feuerwehr Traisa.</p>
    </div>
</template>

<script>
  export default {
    name: "WelcomeMsg"
  }
</script>

<style scoped lang="scss">
    .dottedBorder:after {
        height: 1px;
        width: 100%;
        content: ' ';
        display: block;
        background: repeating-linear-gradient(to right,transparent,transparent 5px,#af4a45 5px,#af4a45 8px);
    }
</style>