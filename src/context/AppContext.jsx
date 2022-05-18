import { createContext, useState } from "react";

export const AppContext = createContext();

const AppProvider = ({ children }) => {
    const [userId, setUserId] = useState();
    const [modal, setModal] = useState(null);
    const onClose = () => setModal(null);
    console.log({ modal });
    return (
        <AppContext.Provider
            value={{
                userId,
                setUserId,
                modal,
                setModal,
                onClose,
            }}
        >
            {children}
        </AppContext.Provider>
    );
};

export default AppProvider;
