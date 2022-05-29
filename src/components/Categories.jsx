import React from "react";
import {
    MdCardTravel,
    MdRestaurant,
    MdOutlineSpa,
    MdOutlineCardGiftcard,
} from "react-icons/md";

const Categories = ({ onClick }) => {
    return (
        <div className="categories container__medium">
            <div className="categories__buttons">
                <button
                    className="categories__buttons__btn"
                    onClick={onClick}
                    id="1"
                >
                    <MdCardTravel className="categories__buttons__btn__icon" />
                    Reizen
                </button>
                <button
                    className="categories__buttons__btn"
                    onClick={onClick}
                    id="2"
                >
                    <MdRestaurant className="categories__buttons__btn__icon" />
                    Restaurant
                </button>
                <button
                    className="categories__buttons__btn"
                    onClick={onClick}
                    id="3"
                >
                    <MdOutlineSpa className="categories__buttons__btn__icon" />
                    Wellness
                </button>
                <button
                    className="categories__buttons__btn"
                    onClick={onClick}
                    id="4"
                >
                    <MdOutlineCardGiftcard className="categories__buttons__btn__icon" />
                    Artikelen
                </button>
            </div>
        </div>
    );
};

export default Categories;
