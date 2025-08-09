import { defineConfig } from "vite";
import symfonyPlugin from "vite-plugin-symfony";
import path from "path";

export default defineConfig({
  plugins: [symfonyPlugin()],
  build: {
    outDir: "../public/build/local-accommodation-bundle",
    emptyOutDir: true,
    rollupOptions: {
      input: {
        app: path.resolve(__dirname, "./index.js"),
      },
    },
  },
  server: {
    port: 5174,
    strictPort: true,
  },
});
