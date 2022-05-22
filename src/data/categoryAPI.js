import { createApi, fetchBaseQuery } from "@reduxjs/toolkit/query/react";

const categoryAPI = createApi({
    reducerPath: "categoyState",
    baseQuery: fetchBaseQuery({
        baseUrl: "https://www.wdev2.be/fs_sander/api",
    }),
    endpoints: (builder) => ({
        getCategories: builder.query({
            query: () => "/categories",
            providesTags: ["allCategories"],
        }),
        getCategoryById: builder.query({
            query: (id) => `/category/${id}`,
        }),
        postCategory: builder.mutation({
            query: ({ cat_name }) => ({
                url: `/categories`,
                method: "POST",
                body: {
                    cat_name,
                },
            }),
            invalidatesTags: ["allCategories"],
        }),
        patchCategoryById: builder.mutation({
            query: (id, { cat_name }) => ({
                url: `/category/${id}`,
                method: "PATCH",
                body: {
                    cat_name,
                },
            }),
            invalidatesTags: ["allCategories"],
        }),
        deleteCategory: builder.mutation({
            query: (id) => `category/${id}`,
            invalidatesTags: ["allCategories"],
        }),
    }),
});

export default categoryAPI;
export const {
    useGetCategoriesQuery,
    useGetCategoryByIdQuery,
    usePostCategoryMutation,
    usePatchCategoryByIdMutation,
    useDeleteCategoryMutation,
} = categoryAPI;
