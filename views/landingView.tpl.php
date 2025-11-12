@component(head)
<body>
    <div id="landing-view" class="view-container">
      <div class="landing-wrapper">
        <div class="landing-content">
          <h1 class="app-title">{{ APP_NAME }}</h1>
          <p class="app-description">{{ APP_DESCRIPTION }}</p>
          <button onclick="window.location.href='?slug=panel'" class="btn-primary">
            Ver estaciones
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M5 12h14M12 5l7 7-7 7"/>
            </svg>
          </button>
          <p class="app-author">Desarrollado por {{ APP_AUTHOR }}</p>
        </div>
      </div>
    </div>
</body>
</html>