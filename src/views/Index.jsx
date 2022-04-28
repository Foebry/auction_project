import React, { useState } from "react";
import Categories from "../components/Categories";

const Index = () => {
    const [activeFilter, setActiveFilter] = useState([]);

    const handleFilterClick = (e) => {
        const id = e.target.id;
        const classList = e.target.classList;

        classList.toggle("categories__buttons__btn--active");

        if (activeFilter.includes(id)) {
            setActiveFilter(filter.filter((item) => item != id));
        } else {
            setActiveFilter([...filter, id]);
        }
    };

    return (
        <>
            <Categories onClick={handleFilterClick} />
        </>
    );
};

export default Index;
