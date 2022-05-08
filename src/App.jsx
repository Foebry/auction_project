import "./styles/App.scss";
import { BrowserRouter as Router } from "react-router-dom";
import AppProvider from "./context/AppContext";
import Skeleton from "./components/Skeleton";
import Routing from "./components/Routing";

function App() {
    return (
        <>
            <Router>
                <AppProvider>
                    <Skeleton>
                        <Routing />
                    </Skeleton>
                </AppProvider>
            </Router>
        </>
    );
}

export default App;
