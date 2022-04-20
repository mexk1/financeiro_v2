import { BrowserRouter } from "react-router-dom";
import Routes from "./Routes";
import './app.css'

function App() {
  return (
    <BrowserRouter >
      <Routes />
    </BrowserRouter>
  );  
}

export default App;
