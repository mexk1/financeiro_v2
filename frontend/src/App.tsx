import { BrowserRouter } from "react-router-dom";
import Routes from "./Routes";
import './app.css'
import AppContext from "./context/AppContext";

function App() {
  return (
    <AppContext >
      <BrowserRouter >
        <Routes />
      </BrowserRouter>
    </AppContext>
  );  
}

export default App;
